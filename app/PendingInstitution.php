<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingInstitution extends Model
{
    public function users(){
        return $this->hasMany(User::class);
    }
}
