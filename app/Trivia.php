<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trivia extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function vote_user()
    {
        return $this->hasMany('App\VoteUserStatus');
    }

    public function genre(){
        return $this->hasOne('App\TriviaGenre');
    }
}
