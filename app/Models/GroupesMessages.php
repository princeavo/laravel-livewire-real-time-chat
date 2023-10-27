<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupesMessages extends Model
{
    use HasFactory;

    public function sender(){
        return $this->belongsTo(User::class,"sender_id");
    }

    public function usersCanNotReadThisMessage(){
        return $this->belongsToMany(User::class,'users_who_can_not_read_this_groupe_message');
    }

    public function usersHaveThisMessageFavorite(){
        return $this->belongsToMany(User::class,'groupes_favorites_messages');
    }
}
