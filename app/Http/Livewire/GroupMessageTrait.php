<?php

namespace App\Http\Livewire;

use App\Models\GroupesMessages;
use Exception;
use Illuminate\Support\Facades\Storage;

trait GroupMessageTrait{
    public $data;

    public function mount($data){
        $this->data = $data;
    }

    public function addMessageToGroupBookMark(){
        if(!$this->data['isUserLeaveGroup']){
            try{
                auth()->user()->messagesFavoritesGroupes()->attach($this->data['id']);
                $this->data['isSaved'] = true;
            }catch(Exception $e){

            }
        }else{
            die();
        }

    }

    public function deleteMessageToGroupBookMark(){
        if(!$this->data['isUserLeaveGroup']){
            try{
                auth()->user()->messagesFavoritesGroupes()->detach($this->data['id']);
                $this->data['isSaved'] = false;
            }catch(Exception $e){

            }
        }else{
            die();
        }

    }

    public function deleteGroupMessageForMe(){
        if(!$this->data['isUserLeaveGroup']){

        }else{
            die();
        }
        $message = GroupesMessages::find($this->data['id']);
        $message->usersCanNotReadThisMessage()->attach(auth()->user()->id);

        $this->data = null;

        /**
        //  * @var  \Illuminate\Support\Collection
         */
        // $d = $message->usersCanNotReadThisMessage;
        // $d->contains(function ($user){
        //     return $user->id == auth()->user()->id;
        // });
    }

    public function deleteGroupMessage(){

        if(!$this->data['isUserLeaveGroup']){
            //Je vais voir si il est un admin d'abord

            if($this->data['isUserAdminForThisGroup']){
                $message = GroupesMessages::find($this->data['id']);
                $this->delete($message);
                $this->data = null;
            }else{
                die();
            }
        }else{
            die();
        }
    }

    private function delete($message){
        if(!$this->data['isUserLeaveGroup']){
            if($message->image){
                Storage::disk('public')->delete($message->image);
            }
            $message->delete();
        }else{
            die();
        }

    }

    public function forwadMessage(){
        if(!$this->data['isUserLeaveGroup']){
            $this->emitTo('forward-message-modal-component','forwardGroupeMessage',$this->data['id']);
        }
    }
}
