<?php

namespace App\Http\Livewire;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddTofavoritesComponent extends Component
{
    public $userId;

    public $listeners = ['addFavoriteDiscussion','addFavoritegroup'];

    public function mount(){
        $this->userId = auth()->user()->id;
    }

    public function render()
    {
        return view('livewire.add-tofavorites-component');
    }
    public function addFavoriteDiscussion($discussionId)
    {
        try{
            DB::table('discussions_favorites')->insert([
                'discussion_id' => $discussionId,
                'user_id' => $this->userId
            ]);
        }catch(Exception $e){

        }
    }

    public function addFavoritegroup($groupeId){
        try{
            DB::table('groupes_favorites')->insert([
                'groupe_id' => $groupeId,
                'user_id' => $this->userId
            ]);
        }catch(Exception $e){

        }
    }
}
