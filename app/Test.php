<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'title',
        'course',
        'description',
        'date',
        'user_id',
        'category_id',
    ];

    public function users(){

        return $this->belongsTo('App\User');

    }
    
    public function categories(){

        return $this->belongsTo('App\Categorie');

    }

    public function questions(){

        return $this->belongsToMany('App\Question')->withTimestamps();

    }
}
