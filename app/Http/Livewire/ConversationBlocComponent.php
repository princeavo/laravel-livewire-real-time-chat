<?php

namespace App\Http\Livewire;

use App\Models\Groupe;
use App\Models\Message;
use Livewire\Component;
use App\Models\Discussion;
use App\Models\GroupesMessages;
use Exception;
use Illuminate\Support\Facades\DB;

class ConversationBlocComponent extends Component
{
    /**
     * isAnConversationSelected
     *
     * @var bool
     */
    // public  $isAnConversationSelected = false;

    public string $messageContent;

    // public $group_id ;

    protected $listeners = [
        "showGroup",
        "showDiscussion",
        "refresh",
        'closeDiscussion',
    ];


    // public function mount(){
    //     Carbon::setLocale('fr');
    // }

    // public function hydrate(){
    //     Carbon::setLocale('fr');
    // }

    // public function hydrate(){
    //     if(session()->has('groupActifId')){
    //         $this->group_id = session('groupActifId');
    //         // $this->isAnConversationSelected = true;
    //     }
    // }

    private function isLeavedGroup($group_id)
    {
        // return Db::table('leave_group')->where('user_id',auth()->user()->id)->get();
        return Db::table('leave_group')->where('groupe_id', $group_id)->where('user_id', auth()->user()->id)->get(['created_at'])->first()->created_at ?? false;
    }

    public function render()
    {
        if (session()->has('groupActifId')) {

            $isUserLeaveGroup = $this->isLeavedGroup(session()->get('groupActifId'));

            if ($isUserLeaveGroup) {
                session()->put('essai', $isUserLeaveGroup);
            }
            // else{
            //     session()->put('essai','vrai');
            // }

            $data = [
                "groupe" => Groupe::where("id", session()->get('groupActifId'))->with(["messages.sender", "creator.pays", "membres", 'messages.usersCanNotReadThisMessage', 'userLeavedGroup', 'messages.usersHaveThisMessageFavorite'])->first()
            ];


            $data['groupe']['membres'] = $data['groupe']['membres']->diff($data['groupe']['userLeavedGroup']);

            unset($data['groupe']['userLeavedGroup']);

            // dd($data['groupe']['membres']);

            session()->forget('essai');

            $data['isUserLeaveGroup'] = $isUserLeaveGroup;

            $AboutGroupData = [
                "groupe" => [
                    "creator" => [
                        "lastname" => $data['groupe']['creator']['lastname'],
                        "firstname" => $data['groupe']['creator']['firstname'],
                        "email" => $data['groupe']['creator']['email'],
                        "pays" => $data['groupe']['creator']['pays'],
                        "contact" => $data['groupe']['creator']['contact'],
                    ],
                    "membres" => $data['groupe']['membres'],
                    'id' => $data['groupe']['id'],
                    'nom' => $data['groupe']['nom'],
                    'description' => $data['groupe']['description'],
                    'photo' => $data['groupe']['photo'],

                    "hideOptions" => false,
                ]
            ];

            // dd($AboutGroupData);

            if ($isUserLeaveGroup) {
                $AboutGroupData['groupe']['hideOptions'] = true;
            }


            // dd($data);
            // $this->emitTo("about-group-component","showGroup",$AboutGroupData);
            // $this->dispatchBrowserEvent('activeGroup', ['id' => session()->get('groupActifId')]);
        } elseif (session()->has('discussionActifId')) {

            $discussion = Discussion::where("id", session()->get('discussionActifId'));
            $favoritesCollection = DB::table("messages_favorites")->where('user_id', auth()->user()->id)->get('message_id');
            $favorites = [];
            foreach ($favoritesCollection as $obj) {
                $favorites[] = $obj->message_id;
            }
            $discussion = $discussion->with(["user1", "user2", "messages"])->first();
            $discussion->messages = $discussion->messages->reverse();
            $data = [
                "discussion" => $discussion,
                "favorites" => collect($favorites)
            ];
            // $this->emitTo("top-component","showDiscussion",$data);
        } else {
            $data = [];
        }
        return view('livewire.conversation-bloc-component', $data);
    }

    public function showGroup($id)
    {
        // $this->group_id = $id;
        // $this->isAnConversationSelected = true;
        $this->dispatchBrowserEvent('scrollToLastMessage');
        session()->forget("discussionActifId");
        session()->put("groupActifId", $id);
        $this->emitTo('loading-component', 'loadFinished');
        // $this->dispatchBrowserEvent('activeGroup', ['id' => $id]);

        // $this->emitTo('top-component','refreshEvent');

    }

    public function showDiscussion($id)
    {
        $this->dispatchBrowserEvent('scrollToLastMessage');
        session()->forget("groupActifId");
        session()->put("discussionActifId", $id);
        $this->emitTo('loading-component', 'loadFinished');
        // $this->dispatchBrowserEvent('activeDiscussion', ['id' => $id]);
    }

    public function newMessage()
    {
        $this->validate([
            "messageContent" => "required"
        ]);
        if (session()->has('groupActifId')) {
            $newGroupMessage = new GroupesMessages;

            $newGroupMessage->groupe_id =  session()->get('groupActifId');
            $newGroupMessage->contenu =  $this->messageContent;
            $newGroupMessage->sender_id =  auth()->user()->id;

            $newGroupMessage->save();

            $this->dispatchBrowserEvent('newMessageSentFromADiscussion');
        } elseif (session()->has('discussionActifId')) {
            $discussion = Discussion::where('id', '=', session()->get('discussionActifId'))->first();

            if ($discussion->user1_id == auth()->user()->id) {
                $receiver_id = $discussion->user2_id;
            } else {
                $receiver_id = $discussion->user1_id;
            }

            $newMessage = new Message;

            $newMessage->contenu = $this->messageContent;
            $newMessage->sender_id = auth()->user()->id;
            $newMessage->receiver_id = $receiver_id;
            $newMessage->discussion_id = session()->get('discussionActifId');

            $newMessage->save();
            $listenerMessage = \Illuminate\Support\Str::limit($this->messageContent ?? "", 25);

            // $this->emit("newMessageSent");
            $this->dispatchBrowserEvent('newMessageSentFromADiscussion', ["message" => $listenerMessage, "id" => $newMessage->discussion_id]);
        }


        $this->messageContent = "";

        $this->dispatchBrowserEvent('scrollToLastMessage');
    }

    public function refresh()
    {
        return $this->render();
    }

    public function deleteGroupMessage(GroupesMessages $message)
    {
        $message->delete();
    }

    public function deleteGroupMessageForMe(GroupesMessages $message)
    {
        $message->usersCanNotReadThisMessage()->attach(auth()->user()->id);

        /**
         * @var  \Illuminate\Support\Collection
         */
        $d = $message->usersCanNotReadThisMessage;
        $d->contains(function ($user) {
            return $user->id == auth()->user()->id;
        });
    }

    public function addMessageToGroupBookMark($groupeMessageId)
    {
        try {
            auth()->user()->messagesFavoritesGroupes()->attach($groupeMessageId);
        } catch (Exception $e) {
        }
    }

    public function deleteMessageToGroupBookMark($groupeMessageId)
    {
        try {
            auth()->user()->messagesFavoritesGroupes()->detach($groupeMessageId);
        } catch (Exception $e) {
        }
    }

    public function deleteDiscussionMessageForMe(Message $discussionMessage)
    {


        $authUserId = auth()->user()->id;
        if ($discussionMessage->sender_id == $authUserId) {
            $discussionMessage->isVisibleForSender = 0;
        } elseif ($discussionMessage->receiver_id == $authUserId) {
            $discussionMessage->isVisibleForReceiver = 0;
        } else {
            //Ici je dois désactiver le compte de l'user en cours puisqu'il n'est ni le sender ni le recever du message
            die();
        }

        if ($discussionMessage->isVisibleForReceiver == 0 && $discussionMessage->isVisibleForSender == 0)
            $discussionMessage->delete();
        else
            $discussionMessage->save();
    }

    public function deleteDiscussionMessage($discussionMessageId)
    {
        Message::where('id', '=', $discussionMessageId)->delete();
    }

    public function addMessageToDiscussionBookMark($discussionMessageId)
    {
        try {
            auth()->user()->messagesFavorites()->attach($discussionMessageId);
        } catch (Exception $e) {
        }
    }

    public function deleteMessageToDiscussionBookMark($discussionMessageId)
    {
        try {
            auth()->user()->messagesFavorites()->detach($discussionMessageId);
        } catch (Exception $e) {
        }
    }

    public function closeDiscussion()
    {
        session()->forget(['groupActifId']);
        session()->forget(['discussionActifId']);
    }
}


//JE vais refaire cela dans le code de la relation user
