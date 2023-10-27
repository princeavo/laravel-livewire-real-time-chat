<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GroupMessageSentComponent extends Component
{
    use GroupMessageTrait;

    public $listeners = ['groupLeave'];

    public function groupLeave(){
        $this->data['isUserLeaveGroup'] = true;
    }

    public function render()
    {
        return view('livewire.group-message-sent-component');
    }
}
