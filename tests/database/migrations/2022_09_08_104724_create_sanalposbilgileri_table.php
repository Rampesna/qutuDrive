<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanalposbilgileriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanalposbilgileri', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('AKTIFPOS', 250)->nullable();
            $table->string('KULLANICIKODU', 250)->nullable();
            $table->string('APIKULLANICIADI', 250)->nullable();
            $table->string('APISIFRE', 250)->nullable();
            $table->string('BAYIKODU', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanalposbilgileri');
    }
}
