<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GroupComponent extends Component
{

    public $data;
    // id
    //photo
    //nom
    // nombresMembres
    // numberUnreadMessages

    public function getListeners()
    {
        return [
            'groupPhotoUpdated' . ($this->data['id'] ?? '') => 'groupPhotoUpdated',
            'groupLeave' . ($this->data['id'] ?? '') => 'groupDeleted',
            'groupDeleted' . ($this->data['id'] ?? '') => 'groupDeleted',
        ];
    }

    public function mount($data)
    {
        $this->data = array_merge($data, ['isActive' => session()->has('groupActifId') && session('groupActifId') == $data['id']]);
    }

    public function render()
    {
        return view('livewire.group-component');
    }

    public function showConversation()
    {
        $this->emitTo('loading-component', 'load');
        $this->emit('showGroup', $this->data['id']);

        $this->data['numberUnreadMessages'] = 0;
        $this->data['isActive'] = true;
    }

    public function groupPhotoUpdated($newPhoto)
    {
        if ($this->data) {
            $this->data['photo'] = $newPhoto['photo'];
        }
    }

    public function groupDeleted()
    {
        $this->data = null;
    }
}
