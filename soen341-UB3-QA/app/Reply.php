<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function users()
    {
        return $this->belongsTo('app\Users');
    }

    public function questions()
    {
        return $this->belongsTo('app\Questions');
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
