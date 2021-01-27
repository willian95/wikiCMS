<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("institution_email")->nullable();
            $table->string("pending_institution_name")->nullable();
            $table->unsignedBigInteger("pending_institution_id")->nullable();
            $table->boolean("show_my_email")->default(true);
            $table->text("why_do_you_educate")->nullable();

            $table->foreign("pending_institution_id")->references("id")->on("pending_institutions");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
