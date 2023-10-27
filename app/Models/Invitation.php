<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    public function recever(){
        return $this->belongsTo(User::class,"recever_id");
    }

    public function sender(){
        return $this->belongsTo(User::class,"sender_id");
    }
}
