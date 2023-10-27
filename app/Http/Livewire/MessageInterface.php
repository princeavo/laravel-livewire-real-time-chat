<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Message;
use App\Models\Discussion;
use App\Events\DeleteDiscussionMessageEvent;

trait MessageInterface {

    public $data;

    public function mount($data){
        if(isset($data['isDeleted']) && $data['isDeleted']){
            $this->data = ["isDeleted" => true, "contenu" => "This message is deleted"];
        }
        else{
            $data['isDeleted'] = 0;
            $this->data = $data;
        }
    }

    public function addMessageToDiscussionBookMark(){
        try{
            auth()->user()->messagesFavorites()->attach($this->data['id']);
            $this->data['isSaved'] = true;
        }catch(Exception $e){

        }
    }

    public function deleteMessageToDiscussionBookMark(){
        try{
            auth()->user()->messagesFavorites()->detach($this->data['id']);
            $this->data['isSaved'] = false;
        }catch(Exception $e){

        }
    }

    public function deleteDiscussionMessageForMe(){


        $authUserId = auth()->user()->id;
        $message = Message::where('id',$this->data['id'])->first();


        if($message->sender_id == $authUserId){
            $message->isVisibleForSender = 0;
            $this->data = ['id' => $this->data['id']];
        }elseif($message->receiver_id == $authUserId){
            $message->isVisibleForReceiver = 0;
            $this->data = ['id' => $this->data['id']];
        }else{
            //Ici je dois désactiver le compte de l'user en cours puisqu'il n'est ni le sender ni le recever du message
            die();
        }

        if($message->isVisibleForReceiver == 0 && $message->isVisibleForSender == 0){
            $this->deleteMessage();
        }
        else{
            $message->save();
        }
    }



    public function forwadMessage(){
        $this->emitTo('forward-message-modal-component','forwardDiscussionMessage',$this->data['id']);
    }
}
