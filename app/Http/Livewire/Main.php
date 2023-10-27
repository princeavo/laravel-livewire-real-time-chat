<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Main extends Component
{
    public function render()
    {
        return view('livewire.main');
    }
    public function closeDiscussion(){
        session()->forget(['groupActifId']);
        session()->forget(['discussionActifId']);
    }
}
