<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKullanicimacadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanicimacadres', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->text('KULLANICIAPIKEY')->nullable();
            $table->text('MACADRES')->nullable();
            $table->integer('DURUM')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullanicimacadres');
    }
}
