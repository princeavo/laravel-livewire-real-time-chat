<?php

namespace App\Http\Livewire;

use App\Models\Groupe;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageGroupInfosComponent extends Component
{
    use WithFileUploads;
    public $data;

    public $photo = null;

    public function mount($data){
        $this->data = $data;
        // dd($data);
        // $this->data['hideOptions'] = false;
    }

    public function render()
    {
        return view('livewire.manage-group-infos-component');
    }

    public function updatedPhoto(){
        if(!$this->data['hideOptions']){
            $this->validate([
                'photo' => "required|image|max:1024"
            ],[
                'photo.image' => "Veuillez choisir une image",
                "photo.max" => "Taille max:1Mo"
            ]);
            $groupId = $this->data["id"];

            $groupe = Groupe::where('id' , '=' , $groupId)->first();

            $oldPhoto = $groupe->photo;

            if($oldPhoto != "groupe_images/default.jpg")
                Storage::disk("public")->delete($oldPhoto);

            $this->data['photo'] = $this->photo->store("groupe_images","public");

            $groupe->photo = $this->data['photo'];

            $groupe->save();

            session()->flash("groupeSuccessAlert","Photo updated Successfully");

            $this->emitTo('group-photo-component','groupPhotoUpdated',['photo' => $this->data['photo']]);
            $this->emitTo('group-component','groupPhotoUpdated'.$groupId,['photo' => $this->data['photo']]);

            $this->photo = null;
        }else{
            die();
        }

    }

    public function leaveGroup(){

        if(!$this->data['hideOptions']){
            // DB::delete('delete from groupe_user where user_id = ? AND groupe_id = ?', [auth()->user()->id,$this->data['id']]);

            try{
                DB::table('leave_group')->insert(
                    [
                        "groupe_id" => $this->data['id'],
                        "user_id" => auth()->user()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                // session()->forget('groupActifId');

                // $this->emitTo('conversation-bloc-component','refresh');
                $this->emitTo('send-message-component','groupLeave');
                $this->emitTo('member-of-group-component','groupLeave');
                $this->emitTo('group-message-sent-component','groupLeave');
                $this->emitTo('group-message-receved-component','groupLeave');
                $this->emitTo('about-group-component','groupLeave');

                $this->data['hideOptions'] = true;
            }catch(\Exception $e){

            }
        }else{
            die();
        }

    }

    public function deleteGroupe(){
        if(!$this->data['hideOptions'] && $this->data['isAdmin']){
            $groupeASupprimer = Groupe::where('id' , '=' , $this->data['id'])->first();

            $photoDuGroupeASupprimer = $groupeASupprimer->photo;


            if($photoDuGroupeASupprimer != 'groupe_images/default.jpg'){
                Storage::disk('public')->delete($photoDuGroupeASupprimer);
            }

//!Je dois mettre ceci dans un job

            $groupeASupprimer->membres()->detach();
            $groupeASupprimer->messages()->delete();

            $groupeASupprimer->delete();

            session()->forget('groupActifId');


            $this->emitTo('conversation-bloc-component','refresh');
            $this->emitTo('group-component','groupDeleted'.$this->data['id']);
        }else{
            die();
        }
    }
}
