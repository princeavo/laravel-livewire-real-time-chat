<?php

namespace App\Http\Livewire;

use App\Models\Discussion;
use App\Models\GroupesMessages;
use App\Models\Message;
use Livewire\Component;

class ForwardMessageModalComponent extends Component
{
    public $user;

    public $contactForForward;
    public $sendToAllContacts = false;

    public $messageForForward;

    public $listeners = ['forwardDiscussionMessage','forwardGroupeMessage'];

    public $discussionMessageId;
    public $groupeMessageId;

    public $areWeBeforeSubmit;

    public function mount(){
        $this->user = auth()->user();
        $this->areWeBeforeSubmit = true;
    }

    public function render()
    {
        $contacts = [];

            $contacts = $this->user->contacts()->with("user1","user2")->get();

            $contacts = $contacts->sort(function($contact1,$contact2){
                $contact1->user = ($contact1->user1->id == $this->user->id ) ? $contact1->user2 : $contact1->user1;
                $contact2->user = ($contact2->user1->id == $this->user->id ) ? $contact2->user2 : $contact2->user1;

                if(strtoupper($contact1->user->firstname) > strtoupper($contact2->user->firstname))
                    return 1;
                elseif(strtoupper($contact1->user->firstname) < strtoupper($contact2->user->firstname))
                    return -1;
                else
                    return 0;
            });
            $contact = $contacts->first();
            if($contacts->count() == 1)
                $contact->user = ($contact->user1->id == $this->user->id ) ? $contact->user2 : $contact->user1;

        if($this->areWeBeforeSubmit){
            if($this->discussionMessageId){
                $this->messageForForward = Message::find($this->discussionMessageId)->contenu;
            }elseif($this->groupeMessageId){
                $this->messageForForward = GroupesMessages::find($this->groupeMessageId)->contenu;
            }
        }



        return view('livewire.forward-message-modal-component',['contacts' => $contacts]);
    }

    public function forwardDiscussionMessage($discussionMessageId){
        $this->discussionMessageId = $discussionMessageId;
        $this->groupeMessageId = null;
    }

    public function forwardGroupeMessage($groupeMessageId){
        $this->groupeMessageId = $groupeMessageId;
        $this->discussionMessageId = null;
    }
    // public function sendMessageTo

    public function forward(){
        $this->validate(['messageForForward' => 'required|string'],['messageForForward.required' => "Vous ne pouvez pas envoyer un message vide"]);
        foreach ($this->contactForForward as $contact) {
            $message = $this->sendMessageToContact($contact,$this->messageForForward);

            if($this->contactForForward[count($this->contactForForward) - 1] == $contact){
                // session()->forget('groupActifId');

                $this->emitTo('discussion-component','showApercuMessageWithReset'.$message->discussion_id,$this->messageForForward);

                if($message->discussion_id == session()->get('discussionActifId')){
                    $data = [
                        "contenu" => $this->messageForForward,
                        "date" => $message->created_at->format("d/m/y H:i:s"),
                        "id" =>$message->id,
                        'isSaved' => false,
                        'sentFromMe' => true,
                        'read' => false
                    ];
                    $this->emitTo('test-component',"newMessageSentFromADiscussion",$data);
                }

                // session()->put('discussionActifId',$message->discussion_id);
            }

        }
    }

    private function sendMessageToContact($user_id,$message){

        $discussion_id = $this->createADiscussionBetween($this->user->id,$user_id);

        $messageModel = new Message;

        $messageModel->contenu = $message;
        $messageModel->sender_id = $this->user->id;
        $messageModel->receiver_id = $user_id;
        $messageModel->discussion_id = $discussion_id;

        $messageModel->save();

        return $messageModel;
    }

    /**
     * Method isADiscussionBetween
     *
     * @param $user1_id $user1_id [explicite description]
     * @param $user2_id $user2_id [explicite description]
     *
     * @return int
     */
    private function createADiscussionBetween($user1_id,$user2_id){
        $discussion = Discussion::where('user1_id' , '=' , $user1_id)->where('user2_id' , '=' , $user2_id)->orWhere('user1_id' , '=' , $user2_id)->where('user2_id' , '=' , $user1_id)->first();
        if($discussion == null){
            $discussion = Discussion::create([
                'user1_id' => $user1_id,
                'user2_id' => $user2_id,
            ]);
        }

        return $discussion->id;

    }
}
