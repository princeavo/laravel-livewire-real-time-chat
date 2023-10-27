<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChangeBachgroundProfileImageComponent extends Component
{
    use WithFileUploads;

    public $backgroundImage;

    public function render()
    {
        if($this->backgroundImage){
            $data = [];
        }else{
            $data= [
                "photo" => auth()->user()->backgroundImage
            ];
        }
        return view('livewire.change-bachground-profile-image-component',$data);
    }

    public function updatedBackgroundImage(){
        $this->validate([
            "backgroundImage" => "image|max:1024"
        ]);

        $newbackground = $this->backgroundImage->store('usersBackgroundImages','public');

        $user = auth()->user();

        $oldBackground = $user->backgroundImage;

        $user->backgroundImage = $newbackground;
        if($oldBackground != 'default.jpg'){
            Storage::disk('public')->delete($oldBackground);
        }

        $user->save();
    }
}
