<?php

namespace App\Http\Livewire;

use App\Models\Pays;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PersonalInfoComponent extends Component
{

    public string $lastname;
    public string $firstname;
    public string $email;
    public ?string $contact;
    public string $pays_id;
    public string $status;

    // public $user;

    public function mount()
    {
        $this->initialize(auth()->user()->loadMissing(["pays"]));
    }

    // public function hydrate(){
    //     $this->initialize();
    // }

    public function render()
    {
        return view('livewire.personal-info-component', [
            "pays" => Pays::all()
            // "user" => $this->user
        ]);
    }

    public function updateProfile()
    {
        $validated = $this->validate([
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique("users", "email")->ignore(auth()->user()->id)],
            "pays_id" => ["required", 'exists:pays,id'],
            "contact" => ["nullable"],
            "status" => ['required', 'string', 'max:255']
        ]);

        $isUserChangeHisMail = $validated['email'] !== auth()->user()->email;

        if ($isUserChangeHisMail) {
            auth()->user()->email_verified_at = null;
        }

        auth()->user()->fill($validated)->save();

        if ($isUserChangeHisMail) {
            return redirect('/');
        }

        session()->flash('updateProfileSuccessMessage', 'Modifications enrégistreés avec succès');
    }

    public function initialize($user)
    {
        // $user = auth()->user();this->

        $this->lastname = $user->lastname;
        $this->firstname = $user->firstname;
        $this->email = $user->email;
        $this->contact = $user->contact;
        $this->pays_id = $user->pays->id;
        $this->status = $user->status;
    }
}
