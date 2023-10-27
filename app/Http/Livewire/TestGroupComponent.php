<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestGroupComponent extends Component
{
    public $componentsData;

    public $isUserLeaveGroup;

    public function mount($isUserLeaveGroup){
        $this->isUserLeaveGroup = $isUserLeaveGroup;
    }

    public $listeners = ['newMessageSentFromAGroup'];

    /*
        ['contenu' => $message->contenu,'id' => $message->id,'date' => $message->created_at->format("d/m/y H:m:i"),'isSaved' => $isUserAddThisMessageInFavorite,'isUserAdminForThisGroup'=>$isUserAdminForThisGroup,'sender'=>['profile_photo'=>$message->sender->profile_photo,'firstname'=>$message->sender->firstname]]
    */
    public function render()
    {
        return view('livewire.test-group-component');
    }

    public function newMessageSentFromAGroup($data){
        if(!isset($data['sentFromMe']))
            $data['sentFromMe'] = false;
        $this->componentsData[] = array_merge($data,['isUserLeaveGroup' => $this->isUserLeaveGroup]);
        $this->dispatchBrowserEvent("scrollToLastMessage");
    }
}
