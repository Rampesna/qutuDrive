<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusterilerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musteriler', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('APIKEY', 250)->nullable();
            $table->string('FIRMAUNVAN', 250)->nullable();
            $table->integer('DURUM')->nullable();
            $table->string('BAYIKODU', 45)->nullable();
            $table->string('YETKILI', 250)->nullable();
            $table->string('VKNTCKN', 45)->nullable();
            $table->string('VERGIDAIRESI', 250)->nullable();
            $table->longText('ADRES')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musteriler');
    }
}
