<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketbilgileriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paketbilgileri', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('BAYIKODU', 45)->nullable();
            $table->string('PAKETKODU', 45)->nullable();
            $table->string('PAKETADI', 250)->nullable();
            $table->float('PAKETBOYUTU')->nullable();
            $table->float('PAKETFIYATI')->nullable();
            $table->integer('DURUM')->nullable();
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
        Schema::dropIfExists('paketbilgileri');
    }
}
