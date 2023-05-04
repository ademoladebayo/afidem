<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 512);
            $table->string('middle_name', 512);
            $table->string('last_name', 512);
            $table->string('gender', 512);
            $table->string('religion', 512);
            $table->string('dob', 512);
            $table->string('joining_date', 512);
            $table->string('joining_session', 512);
            $table->string('home_address', 512);
            $table->string('state', 512);
            $table->string('image_url', 512);
            // REFRENCE CLASS TABLE
            $table->string('class', 512);
            $table->string('guardian_name', 512);
            $table->string('guardian_phone', 512);
            $table->string('guardian_email', 512);
            $table->string('guardian_address', 512);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
