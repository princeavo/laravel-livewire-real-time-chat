<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('authentication.registration',[
            "pays" => Pays::all()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'genre' => ['required',"in:man,woman"],
            "pays_id" => ["required",'exists:pays,id'],
            "contact" => ["nullable"],
            "date_de_naissance" => ['required', 'date', 'before:' . now()->subYears(13)->format('Y-m-d')],
            'profile_photo' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:1024']
        ]);


            // $table->enum("genre",["man","woman"]);
            // $table->foreignIdFor(Pays::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            // $table->string('contact')->nullable();




        $user = User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            "genre" => $request->genre,
            "pays_id" => $request->pays_id,
            "contact" => $request->contact,
            "date_de_naissance" => $request->date_de_naissance,
            'password' => Hash::make($request->password),
        ]);

        if($request->hasFile('profile_photo')){
            $profile_photo =  $request->file('profile_photo')->store('user_profile_image',"public");
        }
        $user->profile_photo = $profile_photo ?? null;
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
