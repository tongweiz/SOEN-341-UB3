<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
    {
        return $this->hasMany('app\Questions');
    }

    public function replies()
    {
        return $this->hasMany('app\Replies');
    }

    public function likes()
    {
        return $this->hasMany('app\Likes');
    }

    public function dislikes()
    {
        return $this->hasMany('app\Dislikes');
    }
}
