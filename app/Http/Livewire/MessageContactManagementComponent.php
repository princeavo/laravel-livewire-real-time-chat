<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MessageContactManagementComponent extends Component
{
    public $composantACharger = 2;

    // public $listeners = ["one","two","three"];

    public function getListeners()
    {
        return [
            "echo-private:chat.message.2,NewMessageSent" => 'notifyNewOrder',
            'one','two','three'
        ];
    }

    public function one(){
        $this->composantACharger = 1;
    }
    public function two(){
        $this->composantACharger = 2;
    }
    public function three(){
        $this->composantACharger = 3;
    }

    public function render()
    {
        return view('livewire.message-contact-management-component');
    }

    public function notifyNewOrder($event){
        dd($event);
    }
}
