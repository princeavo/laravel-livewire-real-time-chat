<?php

namespace App\Http\Livewire;

use App\Models\Invitation;
use Livewire\Component;

class InvitationsSentComponent extends Component
{

    public $listeners = ['refresh'];

    public function render()
    {
        return view('livewire.invitations-sent-component',[
            "invitationsSent" => auth()->user()->invitationsSent()->with('recever')->get()
        ]);
    }
    public function cancel($invitationId){
        Invitation::where('id' , '=' , $invitationId)->delete();
    }

    public function refresh(){
        return $this->render();
    }
}
