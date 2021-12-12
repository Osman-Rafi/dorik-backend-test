<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('attachment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_submissions', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('class_id');
        });
        Schema::dropIfExists('student_submissions');
    }
}
