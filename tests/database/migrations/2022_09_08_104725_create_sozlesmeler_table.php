<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSozlesmelerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sozlesmeler', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->bigInteger('FIRMAID')->nullable();
            $table->string('VKNTCKN', 45)->nullable();
            $table->longText('SOZLESMEHTML')->nullable();
            $table->string('SOZLESMENO', 250)->nullable();
            $table->string('SOZLESMEID', 250)->nullable();
            $table->integer('DURUM')->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
            $table->dateTime('GUNCELLEMETARIHI')->nullable();
            $table->integer('KULLANICIID')->nullable();
            $table->integer('YAZICI')->nullable();
            $table->integer('PDF')->nullable();
            $table->integer('MANUEL')->nullable();
            $table->longText('EKBELGELER')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sozlesmeler');
    }
}
