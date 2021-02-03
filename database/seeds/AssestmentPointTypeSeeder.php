<?php

use Illuminate\Database\Seeder;
use App\AssestmentPointType;

class AssestmentPointTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(AssestmentPointType::where("id", 1)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 1;
            $assestment->name = "Sustained Inquiry";
            $assestment->icon = "fa fa-glass";
            $assestment->save();
        }

        if(AssestmentPointType::where("id", 2)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 2;
            $assestment->name = "Authenticity";
            $assestment->icon = "fa fa-edit";
            $assestment->save();
        }

        if(AssestmentPointType::where("id", 3)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 3;
            $assestment->name = "Student voice & choice";
            $assestment->icon = "fa fa-tint";
            $assestment->save();
        }

        if(AssestmentPointType::where("id", 4)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 4;
            $assestment->name = "Reflection";
            $assestment->icon = "fa fa-map-marker";
            $assestment->save();
        }

        if(AssestmentPointType::where("id", 5)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 5;
            $assestment->name = "Critique & Revision";
            $assestment->icon = "fa fa-map-marker";
            $assestment->save();
        }

        if(AssestmentPointType::where("id", 6)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 6;
            $assestment->name = "Public product";
            $assestment->icon = "fa fa-plane";
            $assestment->save();
        }

        if(AssestmentPointType::where("id", 7)->count() == 0){
            $assestment = new AssestmentPointType;
            $assestment->id = 7;
            $assestment->name = "Challenging problem or question";
            $assestment->icon = "fa fa-magnet";
            $assestment->save();
        }

        

    }
}
