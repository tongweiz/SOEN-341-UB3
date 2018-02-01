<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reply extends Model
{
    public function users()
    {
        return $this->belongsTo('app\Users');
    }

    public function questions()
    {
        return $this->belongsTo('app\Questions');
    }
}
