<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFissaklamadosyalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fissaklamadosyalar', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable()->index('fissaklamadosyalar_firmaapikey');
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('DONEMLERID', 250)->nullable();
            $table->string('DOSYAADI', 250)->nullable();
            $table->string('DOSYAUZANTISI', 250)->nullable();
            $table->string('SUNUCUDOSYAADI', 250)->nullable();
            $table->float('DOSYABOYUTU')->nullable();
            $table->string('YERELDOSYAYOLU', 250)->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
            $table->integer('DURUM')->nullable();
            $table->float('ZIPDOSYABOYUTU')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fissaklamadosyalar');
    }
}
