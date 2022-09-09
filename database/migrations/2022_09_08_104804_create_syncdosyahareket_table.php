<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncdosyahareketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syncdosyahareket', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable()->index('syncdosyahareket_firmaapikey');
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('SUNUCUKLASORLERID', 250)->nullable();
            $table->string('DOSYAADI', 250)->nullable();
            $table->string('DOSYAUZANTISI', 250)->nullable();
            $table->string('YERELDOSYAYOLU', 250)->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
            $table->integer('DURUM')->nullable();
            $table->float('DOSYABOYUTU')->nullable();
            $table->dateTime('SILINMETARIHI')->nullable();
            $table->dateTime('DOSYADEGISTIRILMETARIHI')->nullable();
            $table->float('ZIPDOSYABOYUTU')->nullable();
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
        Schema::dropIfExists('syncdosyahareket');
    }
}
