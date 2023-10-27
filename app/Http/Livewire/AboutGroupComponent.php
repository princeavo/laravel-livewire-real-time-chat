<?php

namespace App\Http\Livewire;

use App\Models\Groupe;
use Livewire\Component;
// use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

//je dois reprendre ceci puisque normalement je dois seulement passer les id au niveau des évennements

//!important je dois vérifier si hideOption est à false avant de tout faire

class AboutGroupComponent extends Component
{
    // use WithFileUploads;
    public $data;

    public $nomGroupe,$descriptionGroupe;

    public $photo = null;


    // public $listeners = ["showGroup",'refresh'];

    public $listeners = ['groupLeave'];

    // public $style = "none";

    public function mount($data){
        // dd($data);
        $this->data = $data;
        $this->nomGroupe = $this->data['groupe']['nom'];
        $this->descriptionGroupe = $this->data['groupe']['description'];
    }

    // public function hydrate(){
    //     $this->nomGroupe = $this->data['groupe']['nom'];
    //     $this->descriptionGroupe = $this->data['groupe']['description'];
    // }

    public function render()
    {
        return view('livewire.about-group-component',array_merge($this->data,["style" => $this->photo ==null  ? false:true]));
    }

    // public function showGroup(){
    //     $data = [
    //         "groupe" => Groupe::where("id", session()->get('groupActifId'))->with(["creator.pays","membres"])->first()
    //     ];
    //     // dd($data);
    //     // dd($data['groupe']['membres'][0]['pivot']);
    //     $this->data = $data;
    //     $this->nomGroupe = $this->data['groupe']['nom'];
    //     $this->descriptionGroupe = $this->data['groupe']['description'];
    // }

    // public function updatedPhoto(){
    //     $this->validate([
    //         'photo' => "required|image|max:1024"
    //     ],[
    //         'photo.image' => "Veuillez choisir une image",
    //         "photo.max" => "Taille max:1Mo"
    //     ]);
    //     $groupId = $this->data['groupe']["id"];

    //     $groupe = Groupe::where('id' , '=' , $groupId)->first();

    //     $oldPhoto = $groupe->photo;

    //     if($oldPhoto != "groupe_images/default.jpg")
    //         Storage::disk("public")->delete($oldPhoto);

    //     $groupe->photo = $this->photo->store("groupe_images","public");

    //     $groupe->save();

    //     session()->flash("groupeSuccessAlert","Photo updated Successfully");

    //     // $this->photo = null;

    //     // $this->photo->store('')
    //     // dd($this->photo);
    // }


    // public function nommerAdmin($groupeId,$userId){
    //     DB::update('update groupe_user set isAdmin = 1 where user_id = ? AND groupe_id = ?', [$userId,$groupeId]);

    //     $data = [
    //         "groupe" => Groupe::where("id", session()->get('groupActifId'))->with(["messages.sender","creator.pays","membres"])->first()
    //     ];
    //     // dd($data['groupe']['membres'][0]['pivot']);
    //     $this->data = $data;
    // }
    // public function retirerAdmin($groupeId,$userId){
    //     DB::update('update groupe_user set isAdmin = 0 where user_id = ? AND groupe_id = ?', [$userId,$groupeId]);

    //     $data = [
    //         "groupe" => Groupe::where("id", session()->get('groupActifId'))->with(["messages.sender","creator.pays","membres"])->first()
    //     ];
    //     // dd($data['groupe']['membres'][0]['pivot']);
    //     $this->data = $data;
    // }
    // public function retirerDuGroupe($groupeId,$userId){

    //     DB::delete('delete from groupe_user where user_id = ? AND groupe_id = ?', [$userId,$groupeId]);

    //     $data = [
    //         "groupe" => Groupe::where("id", session()->get('groupActifId'))->with(["messages.sender","creator.pays","membres"])->first()
    //     ];
    //     // dd($data['groupe']['membres'][0]['pivot']);
    //     $this->data = $data;

    //     $this->emitTo('add-member-to-group-modal-component','refresh');
    // }

    // public function quitterLeGroupe($groupeId,$userId){

    //     DB::delete('delete from groupe_user where user_id = ? AND groupe_id = ?', [$userId,$groupeId]);

    //     session()->forget('groupActifId');

    //     $this->emit('refresh');
    // }

    // public function deleteGroupe($groupeId){
    //     $groupeASupprimer = Groupe::where('id' , '=' , $groupeId)->first();

    //     $photoDuGroupeASupprimer = $groupeASupprimer->photo;


    //     if($photoDuGroupeASupprimer != 'groupe_images/default.jpg'){
    //         Storage::disk('public')->delete($photoDuGroupeASupprimer);
    //     }



    //     $groupeASupprimer->membres()->detach();
    //     $groupeASupprimer->messages()->delete();

    //     $groupeASupprimer->delete();

    //     session()->forget('groupActifId');
    //     $this->emit('refresh');
    // }

    public function updateGroupeInfo(){
        if(!$this->data['groupe']['hideOptions']){
            $groupeId = $this->data['groupe']['id'];

            $this->validate([
                "nomGroupe" => ["required","string","max:50",Rule::unique("groupes","nom")->ignore($groupeId)],
                "descriptionGroupe" => "required|string|max:255",
            ],[
                "nomGroupe.required" => "Le nom du groupe est obligatoire",
                "nomGroupe.unique" => "Ce nom est déjà utilisé",
                "nomGroupe.max" => "Le nom ne doit pas dépasser 50 caractères",
                "nomGroupe.string" => "Le nom doit être une chaine de caractères",
                "descriptionGroupe.required" => "Une description est obligatoire pour créer un groupe",
                "descriptionGroupe.max"  => "Votre description est trop longue",
            ]);

            $groupe = Groupe::where('id' , '=' , $groupeId)->update([
                "nom" => $this->nomGroupe,
                "description" => $this->descriptionGroupe,
            ]);

            session()->put('groupeSuccessAlert','Informations modifiées avec succès');


            // DB::update('update groupes set nom = ?,description = ? where id = ?', [$this->nomGroupe,$this->descriptionGroupe,$groupeId]);

            // dd($this->data);
            // $this->emitSelf('refresh');
        }else{
            die();
        }
    }

    // public function refresh(){
    //     return $this->render();
    // }

    public function groupLeave(){
        $this->data['groupe']['hideOptions'] = true;
    }
}
