<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        "user1_id",
        "user2_id",
        "isVisibleForUser1",
        "isVisibleForUser2"
    ];

    public $timestamps = false;

    public function messages()
    {
        return $this->hasMany(Message::class)->oldest();
    }

    public function lastMessage()
    {
        return $this->hasMany(Message::class)->latest();
    }
    public function lastMessageEssai()
    {
        return $this->hasOne(Message::class)->orderBy('created_at','desc');
    }

    // public function user(){
    //     if($this->user1_id == auth()->user()->id){
    //         return $this->belongsTo(User::class,"user2_id");
    //     }
    //     return $this->belongsTo(User::class,"user1_id");
    // }
    public function user1(){
        return $this->belongsTo(User::class,"user1_id");
    }

    public function user2(){
        return $this->belongsTo(User::class,"user2_id");
    }

}
