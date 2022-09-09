<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusterileraltTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musterileralt', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->integer('MUSTERIID')->nullable();
            $table->string('KULLANICIADI', 250)->nullable();
            $table->string('KULLANICISIFRE', 250)->nullable();
            $table->string('APIKEY', 250)->nullable();
            $table->string('AD', 250)->nullable();
            $table->string('SOYAD', 250)->nullable();
            $table->string('TELEFON', 45)->nullable();
            $table->string('FIRMAUNVAN', 250)->nullable();
            $table->integer('DURUM')->nullable();
            $table->integer('KULLANICITIPI')->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
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
        Schema::dropIfExists('musterileralt');
    }
}
