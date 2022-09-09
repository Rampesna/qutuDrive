<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFissaklamaklasorlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fissaklamaklasorler', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable();
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('KAYNAKBILGISAYARADI', 250)->nullable();
            $table->integer('CONSTRTURU')->nullable();
            $table->text('MSSQLCONSTR')->nullable();
            $table->text('ACCESSDOSYAYOLU')->nullable();
            $table->string('ACCESSPAROLA', 250)->nullable();
            $table->string('ODBCADI', 250)->nullable();
            $table->string('ODBCKULLANICIADI', 250)->nullable();
            $table->string('ODBCPAROLA', 250)->nullable();
            $table->text('EXCELDOSYAYOLU')->nullable();
            $table->text('SORGU')->nullable();
            $table->string('ONAYLAYANADSOYAD', 250)->nullable();
            $table->string('MALIMUHURSERINO', 250)->nullable();
            $table->string('MALIMUHURPIN', 250)->nullable();
            $table->string('ZAMANDAMGASILINK', 250)->nullable();
            $table->string('ZAMANDAMGASIKULLANICIADI', 250)->nullable();
            $table->string('ZAMANDAMGASIPAROLA', 250)->nullable();
            $table->integer('AKTIF')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fissaklamaklasorler');
    }
}
