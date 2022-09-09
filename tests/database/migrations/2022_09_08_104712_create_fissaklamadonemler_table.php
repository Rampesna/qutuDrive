<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFissaklamadonemlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fissaklamadonemler', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable();
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('SUNUCUKLASORLERID', 250)->nullable();
            $table->integer('YIL')->nullable();
            $table->integer('AY')->nullable();
            $table->integer('GUN')->nullable();
            $table->integer('DURUM')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fissaklamadonemler');
    }
}
