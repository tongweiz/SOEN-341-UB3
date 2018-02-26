<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'user_id',
    ];

    public function users()
    {
        return $this->belongsTo('app\Users');
    }

    public function replies()
    {
        return $this->hasMany('app\Replies');
    }
}
