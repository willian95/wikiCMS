<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpvoteSystemProjectVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upvote_system_project_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("assestment_point_type_id");
            $table->unsignedBigInteger("project_id");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("project_id")->references("id")->on("projects");    
            $table->foreign("assestment_point_type_id")->references("id")->on("assestment_point_types");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upvote_system_project_votes');
    }
}
