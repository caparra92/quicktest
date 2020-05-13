<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'description',
        'type',
        'level',
        'is_correct',
        'user_id'
    ];

    public function users(){

        return $this->belongsTo('App\User');

    }

    public function answers(){

        return $this->hasMany('App\Answer');

    }

    public function tests(){

        return $this->belongsToMany('App\Test')->withTimestamps();

    }
}
