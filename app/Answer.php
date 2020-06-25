<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'letter',
        'description',
        'question_id'
    ];

    public function questions(){

        return $this->belongsTo('App\Question');

    }
}
