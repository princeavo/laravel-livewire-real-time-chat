<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'profile_photo',
        'genre',
        'pays_id',
        'email',
        'contact',
        'password',
        "date_de_naissance",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Method isScreenLocked
     *
     * chek if user has locked his screen
     *
     * @return bool
     */
    public function isScreenLocked()
    {
        return $this->lockScreen;
    }

    public function groupes()
    {
        return $this->belongsToMany(Groupe::class);
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'user1_id')
        ->orWhere('user2_id', $this->id);


        // return $this->hasMany(Discussion::class)
        //     ->where('user1_id', $this->id)
        //     ->orWhere('user2_id', $this->id);
    }
    public function pays(){
        return $this->belongsTo(Pays::class);
    }

    public function invitationsSent(){
        return $this->hasMany(Invitation::class,"sender_id");
    }

    public function invitationsReceived(){
        return $this->hasMany(Invitation::class,"recever_id")->where('status',"!=","canceled");
    }

    public function contacts(){
        return $this->hasMany(Contact::class,"user1_id")->orWhere('user2_id', auth()->user()->id)->select('user1_id','user2_id');
    }

    public function isAdminForGroupe($groupeId){
        return DB::table("groupe_user")->select(['groupe_user.isAdmin'])->where("user_id",'=',auth()->user()->id)->where("groupe_id",'=',$groupeId)->first();
    }

    public function messagesFavoritesGroupes(){
        return $this->belongsToMany(GroupesMessages::class,"groupes_favorites_messages");
    }

    public function messagesFavorites(){
        return $this->belongsToMany(Message::class,"messages_favorites");
    }
}
