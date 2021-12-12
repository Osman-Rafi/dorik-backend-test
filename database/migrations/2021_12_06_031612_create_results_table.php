<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classrooms')->onDelete('CASCADE');
            $table->integer('total_mark');
            $table->integer('attained_mark');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign('student_id');
            $table->dropForeign('class_id');
        });
        Schema::dropIfExists('results');
    }
}
