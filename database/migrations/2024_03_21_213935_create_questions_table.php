<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->references('id')->on('exams')->cascadeOnDelete();
            $table->text('question');
            $table->string('question_img')->nullable();
            $table->text('option_1')->nullable();
            $table->string('option_1_img')->nullable();
            $table->text('option_2')->nullable();
            $table->string('option_2_img')->nullable();
            $table->text('option_3')->nullable();
            $table->string('option_3_img')->nullable();
            $table->text('option_4')->nullable();
            $table->string('option_4_img')->nullable();
            $table->string('answer');
            $table->enum('tipe', ['PG', 'PG Komplek']);
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
        Schema::dropIfExists('questions');
    }
};
