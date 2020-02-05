<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRank extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
}
