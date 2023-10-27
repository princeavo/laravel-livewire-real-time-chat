<?php

namespace App\Http\Livewire;

use App\Models\Groupe;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateGroupModalComponent extends Component
{
    use WithFileUploads;

    public $nom_group;
    public $membre_group;
    public $description_group;



    public $photo ;



    public function render()
    {

        $user = auth()->user();
        /**
         * @var \Illuminate\Support\Collection
         */
        $contacts = $user->contacts()->with("user1","user2")->get();

        $contacts = $contacts->sort(function($contact1,$contact2) use ($user){
            $contact1->user = ($contact1->user1->id == $user->id ) ? $contact1->user2 : $contact1->user1;
            $contact2->user = ($contact2->user1->id == $user->id ) ? $contact2->user2 : $contact2->user1;

            if(strtoupper($contact1->user->firstname) > strtoupper($contact2->user->firstname))
                return 1;
            elseif(strtoupper($contact1->user->firstname) < strtoupper($contact2->user->firstname))
                return -1;
            else
                return 0;
        });
        $contact = $contacts->first();
        if($contacts->count() == 1)
            $contact->user = ($contact->user1->id == $user->id ) ? $contact->user2 : $contact->user1;
        // dd($contacts);
        return view('livewire.create-group-modal-component',[
            'contacts' => $contacts
        ]);
    }

    public function createGroup(){
        sleep(1);
        $this->validate([
            "nom_group" => "required|string|max:50|unique:groupes,nom",
            "membre_group" => "required|array",
            "description_group" => "required|string|max:255",
            "photo" => "image|max:1024"
        ],[
            "nom_group.required" => "Le nom du groupe est obligatoire",
            "nom_group.unique" => "Ce nom est déjà utilisé",
            "nom_group.max" => "Le nom ne doit pas dépasser 30 caractères",
            "nom_group.string" => "Le nom doit être une chaine de caractères",
            "membre_group.required" => "Vous devez ajouter au moins un membre",
            "description_group.required" => "Une description est obligatoire pour créer un groupe",
            "description_group.max"  => "Votre description est trop longue",
            "photo.max" => "La taille maximale autorisée est de 1 Mo",
            "photo.image" => "Le fichier doit être une image"
        ]);

        $userId = auth()->user()->id;

        $newGroup = new Groupe;
        $newGroup->nom = $this->nom_group;
        $newGroup->description = $this->description_group;
        $newGroup->creator_id = auth()->user()->id;
        $newGroup->photo = $this->photo->store("groupe_images","public");

        $newGroup->save();

        $newGroup->membres()->attach($userId,[
            "isAdmin" => true
        ]);

        $newGroup->membres()->attach($this->membre_group,[
            "isAdmin" => false
        ]);

        $this->nom_group = "";
        $this->membre_group=null;
        $this->photo = null;
        $this->description_group = null;

        session()->flash("groupSuccess","Groupe created Successfully");

        $this->emitTo('message-component','refresh');

    }


}
