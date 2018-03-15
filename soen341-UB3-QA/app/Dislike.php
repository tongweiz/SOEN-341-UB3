<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
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
