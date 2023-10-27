<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GroupPhotoComponent extends Component
{
    /**
     * listeners
     *
     * @var array
     */
    public $listeners = ['groupPhotoUpdated'];
    public $photo;
    public function mount($photo){
        $this->photo = $photo;
    }
    public function render()
    {
        return view('livewire.group-photo-component');
    }

    public function groupPhotoUpdated($NewGroupPhoto){
        $this->photo = $NewGroupPhoto['photo'];
    }
}
