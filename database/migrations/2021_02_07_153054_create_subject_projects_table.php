<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subject_id");
            $table->unsignedBigInteger("project_id");
            $table->timestamps();

            $table->foreign("subject_id")->references("id")->on("subjects");
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
        Schema::dropIfExists('subject_projects');
    }
}
