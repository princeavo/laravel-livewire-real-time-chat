<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddOrRemoveDiscussionFromFavoriteComponent extends Component
{

    /**
     * data = [
     *      "relation_id" => 75
     *      "user_id" => 3
     *       "isGroup" => 1 ou 0
     * ]
     *
     * @var mixed
     */
    // public $data;

    public $isChecked;

    // public function mount($data){
    //     $this->data = $data;
    // }

    public $listeners = ['showDiscussion'];

    public function mount(){
        if(session()->get('groupActifId')){
            $row = DB::select('select user_id from groupes_favorites where groupe_id = ? and user_id = ?',[session()->get('groupActifId'),auth()->user()->id]);
            if($row){
                $this->isChecked = true;
            }else{
                $this->isChecked = false;
            }
        }elseif(session()->get('discussionActifId')){
            $row = DB::select('select user_id from discussions_favorites where discussion_id = ? and user_id = ?',[session()->get('discussionActifId'),auth()->user()->id]);
            if($row){
                $this->isChecked = true;
            }else{
                $this->isChecked = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.add-or-remove-discussion-from-favorite-component');
    }

    public function updatedIsChecked(){
        if(session()->get('groupActifId')){
            if(!$this->isChecked){
                $this->dispatchBrowserEvent('removeToGroupFavorite');
                DB::delete('delete from groupes_favorites where groupe_id = ? and user_id = ?',[session()->get('groupActifId'),auth()->user()->id]);
            }else{
                $this->dispatchBrowserEvent('addToFavorite');
                DB::insert('insert into groupes_favorites values (?,?)',[session()->get('groupActifId'),auth()->user()->id]);
            }
        }elseif(session()->get('discussionActifId')){
            if(!$this->isChecked){
                $this->dispatchBrowserEvent('removeToDiscussionFavorite');
                DB::delete('delete from discussions_favorites where discussion_id = ? and user_id = ?',[session()->get('discussionActifId'),auth()->user()->id]);
            }else{
                $this->dispatchBrowserEvent('addToFavorite');
                DB::insert('insert into discussions_favorites values (?,?)',[session()->get('discussionActifId'),auth()->user()->id]);
            }
        }
    }

    public function showDiscussion(){
        // sleep(2);
    }
}
