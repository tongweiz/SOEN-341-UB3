<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    public function users()
    {
        return $this->belongsTo('app\Users');
    }

    public function replies()
    {
        return $this->hasMany('app\Replies');
    }
}
