<?php

namespace App\Http\Livewire;

use App\Models\Groupe;
use Exception;
use Livewire\Component;

class AddMemberToGroupModalComponent extends Component
{

    public $listeners = ['refresh'];

    public $membre_group;

    public function render()
    {

        $user = auth()->user();
        /**
         * @var \Illuminate\Support\Collection
         */
        $contacts = $user->contacts()->with("user1","user2")->get();

        $groupeActif = Groupe::where('id' , session('groupActifId'))->first();

        if($groupeActif == null)

            return view('livewire.add-member-to-group-modal-component',[
                "contacts"  => collect()
            ]);

        /**
         * @var \Illuminate\Support\Collection
         */
        $membresActuels = $groupeActif->membres;

        // dump($groupeActif->membres);

        $contacts = $contacts->diff($membresActuels);
        // dd($contacts);


        $contacts = $contacts->sort(function($contact1,$contact2) use ($user){
            $contact1->user = ($contact1->user1->id == $user->id ) ? $contact1->user2 : $contact1->user1;
            $contact2->user = ($contact2->user1->id == $user->id ) ? $contact2->user2 : $contact2->user1;

            if(strtoupper($contact1->user->firstname) > strtoupper($contact2->user->firstname))
                return 1;
            elseif(strtoupper($contact1->user->firstname) < strtoupper($contact2->user->firstname))
                return -1;
            else
                return 0;
        })->filter(function($contact) use ($membresActuels){
            foreach($membresActuels as $membre){
                if($membre->id == $contact->id) return false;
            }
            return true;
        });
        $contact = $contacts->first();
        if($contacts->count() == 1){
            $contact->user = ($contact->user1->id == $user->id ) ? $contact->user2 : $contact->user1;
            // dd($contact->user->id);

            foreach($membresActuels as $membre){
                // dd($membre->id,$contact->user->id);
                if($membre->id == $contact->user->id){
                    $contacts = collect();
                    break;
                }
            }
        }

        // dd($contacts);9

        return view('livewire.add-member-to-group-modal-component',[
            "contacts"  => $contacts
        ]);
    }

    public function addMemberToGroup(){
        $this->validate([
            "membre_group" => "required|array",
        ],[
            "membre_group.required" => "Vous devez ajouter au moins un membre",
        ]);
        try{
            Groupe::where('id' , session('groupActifId'))->first()->membres()->attach($this->membre_group);
        }catch(Exception $e){

        }
        session()->flash('groupSuccess','Member added successfully');

        $this->emitUp('refresh');

    }

    public function refresh(){
        return $this->render();
    }
}
