<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    
    use SoftDeletes;

    public function titles(){
        return $this->hasMany(Title::class);
    }

    public function secondaryFields(){

        return $this->hasMany(SecondaryField::class);

    }

    public function hashtagProject(){

        return $this->hasMany(HashtagProject::class);

    }

    public function subjectProjects(){

        return $this->hasMany(subjectProject::class);

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function upvoteSystemProjects(){

        return $this->hasMany(UpvoteSystemProject::class);

    }

}
