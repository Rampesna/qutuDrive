<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncdosyaparcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syncdosyaparca', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable();
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('SYNCDOSYAHAREKETID', 250)->nullable();
            $table->string('DOSYAADI', 250)->nullable();
            $table->dateTime('KAYITTARIHI')->nullable();
            $table->integer('DURUM')->nullable();
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
        Schema::dropIfExists('syncdosyaparca');
    }
}
