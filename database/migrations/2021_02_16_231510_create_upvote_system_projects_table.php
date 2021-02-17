<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpvoteSystemProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upvote_system_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("assestment_point_type_id");
            $table->unsignedBigInteger("project_id");
            $table->timestamps();

            $table->foreign("assestment_point_type_id")->references("id")->on("assestment_point_types");
            $table->foreign("project_id")->references("id")->on("projects");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upvote_system_projects');
    }
}
