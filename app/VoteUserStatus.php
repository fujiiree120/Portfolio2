<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteUserStatus extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trivia(){
        return $this->belongsTo('App\Trivia');
    }
}
