<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        "contenu",
        "sender_id",
        "receiver_id",
        "discussion_id",
        "read",
        "isDeleted"
    ];
}
