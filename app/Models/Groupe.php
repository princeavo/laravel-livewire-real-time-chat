<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Groupe extends Model
{
    use HasFactory;
    protected $fillable = [
        "nom",
        "description",
        "photo",
        "creator_id"
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, "creator_id");
    }

    public function membres()
    {
        return $this->belongsToMany(User::class)->withPivot('isAdmin');
    }

    public function messages()
    {
        // Db::table('leave_group')->where('groupe_id', session()->get('groupActifId'))->where('user_id',auth()->user()->id)->get(['created_at'])->first()->created_at ?? false;

        $isLeaved = session('essai');

        if ($isLeaved) {
            return $this->hasMany(GroupesMessages::class, "groupe_id")->where('created_at', '<', $isLeaved)->oldest()->limit(11);
        }


        return $this->hasMany(GroupesMessages::class, "groupe_id")->oldest()->limit(11);
    }

    public function lastMessage()
    {
        return $this->hasMany(GroupesMessages::class, "groupe_id")->latest();
    }
    public function userLeavedGroup()
    {
        return $this->belongsToMany(User::class, "leave_group");
    }
    // SELECT col1,col2,col3,COUNT(col1) as  nombre FROM table GROUP BY (col1,col2,col3)
}
