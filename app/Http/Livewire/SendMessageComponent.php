<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Models\Discussion;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Events\NewMessageSent;
use App\Models\GroupesMessages;
use Illuminate\Support\Facades\DB;
use App\Events\NewDiscussionMessage;
use Illuminate\Support\Facades\Storage;

class SendMessageComponent extends Component
{
    use WithFileUploads;

    public $listeners = ['groupLeave'];

    public $image = null;

    public $hide = false;
    public $isAdmin = false;

    public $messageContent;

    public function mount($isAdmin = 0)
    {
        $this->isAdmin = $isAdmin;
    }

    public function render()
    {
        return view('livewire.send-message-component');
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


            $path = null;

            if ($this->image) {
                $path = $this->image->store('groupes_messages_images', 'public');
                // DB::table('messages_images')->insert(['type' => 'group','id' => $newGroupMessage->id,'path' => $path]);

                $this->image = null;
            }

            $newGroupMessage->image = $path;
            $newGroupMessage->save();

            $data = [
                'contenu' => $this->messageContent,
                'id' => $newGroupMessage->id,
                'date' => $newGroupMessage->created_at->format("d/m/y H:i:s"),
                'isSaved' => false,
                'sentFromMe' => true,
                'isUserAdminForThisGroup' => $this->isAdmin,
                'isUserLeaveGroup' => $this->hide,
                'image' => $path
            ];

            $this->emit('newMessageSentFromAGroup', $data);


            $this->dispatchBrowserEvent('newMessageSentFromAGroup');

            // $this->dispatchBrowserEvent('newMessageSentFromAGroup',["message" => $newGroupMessage->contenu,"id" => $newGroupMessage->id]);
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

            // $newMessage->save();
            $apercuMessage = Str::limit($this->messageContent ?? "", 25);

            $path = null;

            if ($this->image) {
                $path = $this->image->store('discussions_messages', 'public');
            }

            $newMessage->image = $path;
            $newMessage->save();

            $data = [
                "contenu" => $newMessage->contenu,
                "date" => $newMessage->created_at->format("d/m/y H:i:s"),
                "id" => $newMessage->id,
                // 'disucussion_id' => $newMessage->discussion_id,
                'isSaved' => false,
                'sentFromMe' => true,
                'read' => false,
                'image' => $path
            ];

            $this->image = null;

            $this->emitTo('test-component', "newMessageSentFromADiscussion", $data);

            $data['sentFromMe'] = false;
            $data['sender_id'] = auth()->user()->id;

            // dd(array_merge($data,['receiver_id' => $receiver_id]));

            event(new NewDiscussionMessage(array_merge($data, ['receiver_id' => $receiver_id, 'discussion_id' => session()->get('discussionActifId')])));
            /**
//  * @var \Illuminate\Foundation\Bus\PendingDispatch
//  */
            //             $k = 4;
            //             $k->

            $this->dispatchBrowserEvent('newMessageSentFromADiscussion', ['apercuMessage' => $apercuMessage]);
            $this->dispatchBrowserEvent('scrollToLastMessage');
        }


        $this->messageContent = "";
    }

    // public function updatedPhoto(){

    // }

    public function groupLeave()
    {
        $this->hide = true;
    }
}
