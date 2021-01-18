<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::where("role_id", "1")->count() == 0){
            $admin = new User;
            $admin->name = "Admin";
            $admin->email = "admin@gmail.com";
            $admin->email_verified_at = Carbon::now();
            $admin->password = bcrypt("12345678");
            $admin->role_id = 1;
            $admin->save();
        }
    }
}
