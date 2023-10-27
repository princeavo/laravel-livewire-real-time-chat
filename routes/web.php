<?php

use App\Events\NewMessageSent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(["screenLock","verified"])->group(function(){


    Route::middleware(["auth"])->group(function(){
        Route::get('/', function () {

            // dd(auth()->user()->discussions()->with("LastMessage")->get());

            // dump(auth()->user()->groupes()->with('membres')->get());
            // $groupes = auth()->user()->groupes()->with(['membres','messages'])->get();
            // dd($groupes->find(56));
            return view('main');

        })->name('home');
        Route::get("/recovery",function(){
            return view('auth.recovery');
        });

        Route::get("/change_password",function(){
            return view('change_password');
        });
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });



});






// ----------------------------------------------------------------------------------------------------------------------------








Route::get("/lock-screen",function(){
    return view('lock-screen',[
        "user" => Auth()->user(),
    ]);
})->name("screen_locked");

Route::post("/lock-screen",[UserController::class, "lockScreen"])->name("screen_locked");


// ---------------------------------------------------------------------------------------------------------------------------


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('t',function(){
    broadcast(new NewMessageSent());
    // event(new NewMessageSent());
    dd('success');
});

// nom
// prenom
// email
// date de naissance
// pays
// genre
// image de profil
