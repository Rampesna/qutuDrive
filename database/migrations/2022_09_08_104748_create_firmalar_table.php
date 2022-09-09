<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmalar', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->string('APIKEY', 250)->nullable()->index('firmalar_apikey');
            $table->text('FIRMAUNVAN')->nullable();
            $table->string('VKNTCKN', 45)->nullable();
            $table->string('AD', 250)->nullable();
            $table->string('SOYAD', 250)->nullable();
            $table->string('VERGIDAIRESI', 250)->nullable();
            $table->text('ADRES')->nullable();
            $table->string('TELEFON', 45)->nullable();
            $table->string('MAIL', 150)->nullable();
            $table->string('BAYIKODU', 45)->nullable();
            $table->integer('DURUM')->nullable();
            $table->integer('EDEFTERKAYNAKTURU')->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
            $table->string('BASLANGICYILI', 45)->nullable();
            $table->text('ISLEMDURUMU')->nullable();
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
        Schema::dropIfExists('firmalar');
    }
}
