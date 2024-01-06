<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LoadingComponent extends Component
{
    public bool $isLoading = false;

    public $listeners = ["load" => "setLoadingToTrue", "loadFinished" => "setLoadingToFalse"];

    public function render()
    {
        return view('livewire.loading-component');
    }

    public function setLoadingToTrue(): void
    {
        $this->isLoading = true;
    }
    public function setLoadingToFalse(): void
    {
        $this->isLoading = false;
    }
}
