<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpvoteSystemProject extends Model
{
    public function assestmentPointType(){

        return $this->belongsTo(AssestmentPointType::class);

    }

    public function project(){

        return $this->belongsTo(Project::class);

    }
}
