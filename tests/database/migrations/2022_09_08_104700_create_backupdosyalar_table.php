<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackupdosyalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backupdosyalar', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('FIRMAAPIKEY', 250)->nullable()->index('backupdosyalar_firmaapikey');
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->float('DOSYABOYUTU')->nullable();
            $table->string('BACKUPTURU', 250)->nullable();
            $table->string('BACKUPOLUSMATARIHI', 250)->nullable();
            $table->string('VERITABANIADI', 250)->nullable();
            $table->string('BACKUPDURUMU', 250)->nullable();
            $table->string('ISEMRIBASLIKID', 250)->nullable();
            $table->string('DOSYAADI', 250)->nullable();
            $table->integer('YEDEKDOSYAPARCASAYISI')->nullable();
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
        Schema::dropIfExists('backupdosyalar');
    }
}
