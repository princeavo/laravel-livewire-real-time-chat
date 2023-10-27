<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function lockScreen(Request $request){
        $request->validate([
            "code" => "required"
        ]);

        if(Auth()->user()->unlockScreenCode){
            $codeJuste = Auth()->user()->unlockScreenCode;
        }else{
            $codeJuste = Auth()->user()->password;
        }

        if(Hash::check($request->input('code'),$codeJuste)){
            $user = User::find(Auth()->user()->id);
            $user->lockScreen = 0;
            $user->save();

            return redirect()->intended("/");
        }else{
            return back()->with([
                "error" => 'Invalid code'
            ]);
        }
    }
}
