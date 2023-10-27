<?php

namespace App\Http\Livewire;

use App\Events\MarkAllDiscussionMessageRead;
use App\Events\ReadAllDiscussionMessage;
use App\Models\Message;
use Livewire\Component;
use App\Events\NewDiscussionMessage;
use App\Models\Discussion;

class TestComponent extends Component
{
    public $listeners  = ["newMessageSentFromADiscussion","newMessageSentFromADiscussionJs"];
    public $componentsData = [];
    public $numberUnreadMessages = 0;

    public function mount(){
        Message::where('discussion_id' , '=' , session()->get('discussionActifId'))
                ->where('read','0')
                ->where('receiver_id',auth()->user()->id)
                ->update(["read" => true]);
        $discussion = Discussion::where('id',session()->get('discussionActifId'))->first();

        $receiverId = ($discussion->user1_id == auth()->user()->id) ? $discussion->user2_id : $discussion->user1_id;

        event(new MarkAllDiscussionMessageRead(['receiver_id' => $receiverId]));

        $this->emitTo('discussion-component','resetCount'.session()->get('discussionActifId'));
    }

    public function render()
    {
        return view('livewire.test-component');
    }

    public function newMessageSentFromADiscussion($arg){
        if(!isset($arg['sentFromMe']))
            $arg['sentFromMe'] = false;
        $this->componentsData[] = $arg;
        $this->dispatchBrowserEvent("scrollToLastMessage");
        $this->numberUnreadMessages  = 0;
        // dd($arg);
    }
    public function showDiscussion(){
        $this->componentsData = [];
    }

    public function newMessageSentFromADiscussionJs($data){

        // $this->emitTo('discussion-component','showApercuMessageWithReset'.$data['discussion_id'],$data['contenu']);

        // dd($data);
        if($data['discussion_id'] == session()->get('discussionActifId')){
            $this->numberUnreadMessages ++;
            $this->componentsData[] = $data;
            // $this->dispatchBrowserEvent("scrollToLastMessage");

            //Je vais marquer des vues
            // Message::where('discussion_id' , '=' , $data['discussion_id'])
            //     ->where('read','0')
            //     ->where('receiver_id',auth()->user()->id)
            //     ->update(["read" => true]);

            event(new ReadAllDiscussionMessage(['message_id' => $data['id'],'receiver_id' => $data['sender_id']]));

        }else{
            // dd($data['discussion_id']);
            // $this->emitTo('discussion-component','showApercuMessage'.$data['discussion_id'],$data['contenu']);
        }

    }

    public function resetUnread(){
        $this->numberUnreadMessages = 0;
    }
}
