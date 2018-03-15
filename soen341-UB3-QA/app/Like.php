<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function replies()
    {
        return $this->belongsTo('app\Replies');
    }

    public function users()
    {
        return $this->belongsTo('app\Users');
    }
}
