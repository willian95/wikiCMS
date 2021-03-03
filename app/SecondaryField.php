<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecondaryField extends Model
{
    public function project(){

        return $this->belongsTo(Project::class);

    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
