<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdefterdosyalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edefterdosyalar', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable()->index('edefterdosyalar_firmaapikey');
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
            $table->integer('GIBDURUM')->nullable();
            $table->dateTime('GIBGONDERIMTARIHI')->nullable();
            $table->string('GIBKUYRUKDURUM', 250)->nullable();
            $table->dateTime('GIBKUYRUKTARIHI')->nullable();
            $table->string('DOSYAIMZA', 250)->nullable();
            $table->integer('SERVISDURUMU')->nullable();
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
        Schema::dropIfExists('edefterdosyalar');
    }
}
