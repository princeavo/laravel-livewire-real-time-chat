<?php

namespace App\Http\Livewire;

use App\Models\Discussion;
use App\Models\UsersBloqued;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ContactComponent extends Component
{
    public $listeners = ['refresh'];

    public $utilisateurConnecte;

    public function mount(){
        $this->utilisateurConnecte = auth()->user();
    }

    public function render()
    {
        return view('livewire.contact-component',[
            "contacts" => $this->utilisateurConnecte->contacts()->addSelect([
                'isBlocked1' => UsersBloqued::where('user_who_has_blocked',$this->utilisateurConnecte->id)->whereColumn('user_blocked','=','contacts.user2_id')->select('user_blocked'),
                'isBlocked2' => UsersBloqued::where('user_who_has_blocked',$this->utilisateurConnecte->id)->whereColumn('user_blocked','=','contacts.user1_id')->select('user_blocked')
            ])->with(['user1','user2'])->get()->groupBy(function ($contact) {
                $utilisateurAssocie = $contact->user1_id == auth()->id() ? $contact->user2 : $contact->user1;
                $contact->user = $utilisateurAssocie;
                return strtoupper(substr($utilisateurAssocie->lastname, 0, 1));
            })->sortKeys()
        ]);
    }

    public function refresh(){
        return $this->render();
    }

    public function deleteFromMyContacts($contactId){

        $user_id = auth()->user()->id;

        DB::delete('delete from contacts where (user1_id = ? AND user2_id = ?) or (user1_id = ? AND user2_id = ?) ', [$user_id,$contactId,$contactId,$user_id]);

    }

    public function messageAContact($userId){
        $authUserId = auth()->user()->id;

        $discussion = Discussion::where('user1_id' , $authUserId)->where('user2_id',$userId)->orWhere('user1_id' , $userId)->where('user2_id',$authUserId)->get();

        // dump($discussion);

        if($discussion->isEmpty()){
            $discussion = Discussion::create([
                "user1_id" => $authUserId,
                "user2_id" => $userId
            ]);
        }else{
            if($discussion->count() == 1)
                $discussion = $discussion->first();
            else
                dd();
        }

        $this->emitTo('conversation-bloc-component','showDiscussion',$discussion->id);
    }

    public function blockUser($userId){
        try{
            $userBlocked = new UsersBloqued;

            $userBlocked->user_who_has_blocked = $this->utilisateurConnecte->id;
            $userBlocked->user_blocked = $userId;

            $userBlocked->save();
        }catch(Exception $e){

        }
    }

    public function unBlockUser($userId){
        try{
            UsersBloqued::where('user_who_has_blocked' , '=' , $this->utilisateurConnecte->id)->where('user_blocked' , '=' , $userId)->delete();
        }catch(Exception $e){

        }
    }
}
