<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    protected $fillable = ['firstname', 'lastname', 'username', 'show_username', 'birthday', 'profile_img', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
