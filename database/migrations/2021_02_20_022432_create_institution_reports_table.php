<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institution_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("institution_id");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();

            $table->foreign("institution_id")->references("id")->on("institutions");
            $table->foreign("user_id")->references("id")->on("users");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution_reports');
    }
}
