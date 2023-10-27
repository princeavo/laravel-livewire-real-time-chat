<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ChangeProfilePhotoComponent extends Component
{

    use WithFileUploads;

    public $photo;

    public function render()
    {
        if($this->photo){
            $data = [];
        }else{
            $data = [
                "profile_photo" =>auth()->user()->profile_photo
            ];
        }
        return view('livewire.change-profile-photo-component',$data);
    }

    public function updatedPhoto(){
        $this->validate([
            "photo" => "image|max:1024"
        ]);

        $newProfilePhoto = $this->photo->store('user_profile_image','public');

        $user = auth()->user();

        $photo = $user->profile_photo;

        $user->profile_photo = $newProfilePhoto;
        if($photo != 'man.png'){
            Storage::disk('public')->delete($photo);
        }

        $user->save();
    }
}
