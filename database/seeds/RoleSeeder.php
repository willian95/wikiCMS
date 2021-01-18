<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Role::count() == 0){

            $role = new Role;
            $role->id = 1;
            $role->name = "Admin";
            $role->save();

            $role = new Role;
            $role->id = 2;
            $role->name = "Teacher";
            $role->save();

            $role = new Role;
            $role->id = 3;
            $role->name = "Institution";
            $role->save();

        }

    }   
}
