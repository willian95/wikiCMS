<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdToInstitutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutions', function (Blueprint $table) {

            $table->unsignedBigInteger("country_id")->nullable();
            $table->unsignedBigInteger("state_id")->nullable();
            $table->boolean("part_of_network_institution")->nullable();
            $table->string("which_network")->nullable();
            $table->string("institution_public_or_private")->nullable();
            $table->string("students_enrolled")->nullable();
            $table->string("faculty_members")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutions', function (Blueprint $table) {
            //
        });
    }
}
