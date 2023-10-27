<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Invitation;

class InvitationReceivedComponent extends Component
{

    public $listeners = ['refresh'];
    public function render()
    {
        return view('livewire.invitation-received-component',[
            "invitationsReceived" => auth()->user()->invitationsReceived()->with('sender')->get()
        ]);
    }

    public function refuser(Invitation $invitation){
        $invitation->status = "canceled";
        $invitation->save();
    }

    public function refresh(){
        return $this->render();
    }
}
