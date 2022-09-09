<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBayilerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bayiler', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('BAYIKODU', 45)->nullable();
            $table->string('BAYIUNVAN', 250)->nullable();
            $table->string('BAYITELEFON', 45)->nullable();
            $table->string('BAYIADRES', 250)->nullable();
            $table->float('BAYIORAN')->nullable();
            $table->string('USTBAYIKODU', 45)->nullable();
            $table->integer('DURUM')->nullable();
            $table->string('BAYIVKN', 45)->nullable();
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
        Schema::dropIfExists('bayiler');
    }
}
