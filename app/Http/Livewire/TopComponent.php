<?php

namespace App\Http\Livewire;

use App\Models\Discussion;
use App\Models\Groupe;
use Livewire\Component;


class TopComponent extends Component
{
    public $listeners = ["showDiscussion"];


    public $data;

    public $bool = false;

    public function render()
    {
        // dd($this->data);
        return view('livewire.top-component',
            ["data" => $this->data]
        );
    }
    public function showDiscussion( $data){
        // dd($data);
        $this->data = $data;
    }
    // public function showGroup( $data){
    //     $this->data = $data;
    // }
    public function mount($param){
        $this->data = $param;
        if(isset($param['discussion'])){
            $this->bool = $param['discussion']->isFavorite;
        }
        if(isset($param['groupe'])){
            $this->bool = $param['groupe']->isFavorite;
        }
        // $this->bool = $param[]
    }
    public function updatedBool($val){
        if(isset($this->data['discussion'])){
            Discussion::where('id' , '=' , "{$this->data['discussion']['id']}")->update([
                "isFavorite" => $val
            ]);
            $this->data['discussion']["isFavorite"] = $val;

            $this->emitTo('message-component',"refresh");
            // $this->dispatchBrowserEvent('activeDiscussion', ['id' => $this->data['discussion']['id']]);

        }
        if(isset($this->data['groupe'])){
            Groupe::where('id' , '=' , "{$this->data['groupe']['id']}")->update([
                "isFavorite" => $val
            ]);
            $this->data['groupe']["isFavorite"] = $val;

            $this->emitTo('message-component',"refresh");
        }





        //Je dois revoir les params de la session
    }
}
