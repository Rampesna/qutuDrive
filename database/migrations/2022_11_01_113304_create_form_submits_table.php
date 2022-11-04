<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_submits', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('question_id');
            $table->string('short_answer')->nullable();
            $table->text('long_answer')->nullable();
            $table->unsignedBigInteger('form_question_answer_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_submits');
    }
};
