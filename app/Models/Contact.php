<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ["user1_id","user2_id"];

    public function user1(){
        return $this->belongsTo(User::class,"user1_id")->select('id','firstname','lastname');
    }

    public function user2(){
        return $this->belongsTo(User::class,"user2_id")->select('id','firstname','lastname');
    }

    // public function getuserAttribute(){
    //     $user1 = $this->user1;
    //     $user2 = $this->user2;
    //     if($user1->id == auth()->user()->id){
    //         return $user2;
    //     }
    //     return $user1;
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, $this->user1_id == auth()->id() ? 'user2_id' : 'user1_id');
    // }
}
