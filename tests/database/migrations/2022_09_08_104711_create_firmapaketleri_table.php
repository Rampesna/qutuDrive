<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmapaketleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmapaketleri', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('FIRMAAPIKEY', 45)->nullable()->index('firmapaketleri_firmaapikey');
            $table->string('PAKETKODU', 45)->nullable();
            $table->string('PAKETADI', 250)->nullable();
            $table->float('PAKETBOYUTU')->nullable();
            $table->float('PAKETFIYATI')->nullable();
            $table->dateTime('BASLANGICTARIHI')->nullable();
            $table->dateTime('BITISTARIHI')->nullable();
            $table->integer('DURUM')->nullable();
            $table->string('ODEMESEKLI', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firmapaketleri');
    }
}
