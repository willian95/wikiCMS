<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssestmentPointType extends Model
{
    use SoftDeletes;

    public function upvoteSystemProjects(){

        return $this->hasMany(UpvoteSystemProject::class);

    }

}
