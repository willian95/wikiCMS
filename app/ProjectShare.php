<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectShare extends Model
{
    protected $table = "project_shares";

    public function project(){
        return $this->belongsTo(Project::class);
    }

}
