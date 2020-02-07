<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TriviaGenre extends Model
{
    //

    public function genre(){
        return $this->belongsTo('App\CreateGenre');
    }

    public function trivia()
    {
        return $this->hasOne('App\Trivia');
    }
}
