<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosyasunucubilgileriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosyasunucubilgileri', function (Blueprint $table) {
            $table->string('GUID', 250)->primary()->unique();
            $table->string('SUNUCUTURKODU', 250)->nullable();
            $table->string('SUNUCUURL', 250)->nullable();
            $table->string('SUNUCUACCESSKEY', 250)->nullable();
            $table->string('SUNUCUSECRETKEY', 250)->nullable();
            $table->integer('AKTIF')->nullable();
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
        Schema::dropIfExists('dosyasunucubilgileri');
    }
}
