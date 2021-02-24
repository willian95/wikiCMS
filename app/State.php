<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "states";

    public function institution(){
        return $this->hasMany(Institution::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
