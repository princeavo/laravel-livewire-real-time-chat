<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReceivedDiscussionBroadcoasting extends Component
{
    public $listeners = ["newMessageSentFromADiscussionJs"];
    public function render()
    {
        return view('livewire.received-discussion-broadcoasting');
    }
    public function newMessageSentFromADiscussionJs($data){
        if($data['discussion_id'] !== session()->get('discussionActifId')){
            $this->emitTo('discussion-component','showApercuMessage'.$data['discussion_id'],$data['contenu']);
        }else{
            $this->emitTo('discussion-component','showApercuMessageWithReset'.$data['discussion_id'],$data['contenu']);
        }
        $this->dispatchBrowserEvent('sing');
    }
}
