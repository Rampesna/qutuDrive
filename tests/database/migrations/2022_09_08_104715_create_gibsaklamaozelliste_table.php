<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGibsaklamaozellisteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gibsaklamaozelliste', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->string('FIRMAAPIKEY', 250)->nullable();
            $table->string('VKNTCKN', 45)->nullable();
            $table->string('UNVAN', 250)->nullable();
            $table->integer('DURUM')->nullable();
            $table->dateTime('TARIH')->nullable();
            $table->integer('VIP')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gibsaklamaozelliste');
    }
}
