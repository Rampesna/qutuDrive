<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKullanicilarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->string('APIKEY', 250)->nullable();
            $table->string('KULLANICIADI', 250)->nullable();
            $table->string('KULLANICISIFRE', 250)->nullable();
            $table->string('AD', 250)->nullable();
            $table->string('SOYAD', 250)->nullable();
            $table->string('TELEFON', 45)->nullable();
            $table->string('MAIL', 250)->nullable();
            $table->string('TCNO', 45)->nullable();
            $table->integer('DURUM')->nullable();
            $table->integer('KULLANICITIPI')->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
            $table->dateTime('TOKENTARIHI')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullanicilar');
    }
}
