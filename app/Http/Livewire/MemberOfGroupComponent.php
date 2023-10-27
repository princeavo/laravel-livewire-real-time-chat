<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class MemberOfGroupComponent extends Component
{
    public $data;

    public $listeners = ["groupLeave"];

    public function mount($data){
        if($data['auth']['user_id'] == $data['membre']['id'])
            $data['hideOptions'] = true;
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.member-of-group-component');
    }

    public function retirerDuGroupe(){
        if($this->data['auth']['isAdmin'] && !$this->data['hideOptions']){
            DB::delete('delete from groupe_user where user_id = ? AND groupe_id = ?', [$this->data['membre']['id'],$this->data['groupe']['id']]);

            $this->data = null;

            $this->emitTo('add-member-to-group-modal-component','refresh');
        }else{
            die();
        }
    }

    public function retirerAdmin(){
        if($this->data['auth']['isAdmin'] && !$this->data['hideOptions']){
            DB::update('update groupe_user set isAdmin = 0 where user_id = ? AND groupe_id = ?', [$this->data['membre']['id'],$this->data['groupe']['id']]);

            $this->data['membre']['isAdmin'] = false;
        }else{
            die();
        }
    }

    public function nommerAdmin(){
        if($this->data['auth']['isAdmin']&& !$this->data['hideOptions'] ){
            DB::update('update groupe_user set isAdmin = 1 where user_id = ? AND groupe_id = ?', [$this->data['membre']['id'],$this->data['groupe']['id']]);

            $this->data['membre']['isAdmin'] = true;
        }else{
            die();
        }
    }

    public function groupLeave(){
        $this->data['hideOptions'] = true;
    }
}
