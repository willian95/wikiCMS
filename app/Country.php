<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "countries";

    public function institution(){
        return $this->hasMany(Institution::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
