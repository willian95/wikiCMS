<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondaryFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_fields', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("is_original")->default(false);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("project_id");
            $table->string("type");
            $table->text("description")->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
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
        Schema::dropIfExists('secondary_fields');
    }
}
