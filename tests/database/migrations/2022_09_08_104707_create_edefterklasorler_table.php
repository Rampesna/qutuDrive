<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdefterklasorlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edefterklasorler', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable();
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('KAYNAKBILGISAYARADI', 250)->nullable();
            $table->string('KAYNAKKLASORYOLU', 250)->nullable();
            $table->integer('AKTIF')->nullable();
            $table->integer('WEBSERVISDENINDIR')->nullable();
            $table->string('WEBSERVISKULLANICIADI', 250)->nullable();
            $table->string('WEBSERVISKULLANICIPAROLA', 250)->nullable();
            $table->integer('GIBIKINCILSAKLAMA')->nullable();
            $table->integer('YEDEKBASLANGICYILI')->nullable();
            $table->integer('NASKULLAN')->nullable();
            $table->string('NASDOMAIN', 250)->nullable();
            $table->string('NASKULLANICIADI', 250)->nullable();
            $table->string('NASKULLANICIPAROLA', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edefterklasorler');
    }
}
