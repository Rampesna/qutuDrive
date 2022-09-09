<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKullaniciyetkileriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullaniciyetkileri', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->integer('KULLANICIID')->nullable();
            $table->string('MODUL', 45)->nullable();
            $table->string('YETKI', 45)->nullable();
            $table->string('ROLADI', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullaniciyetkileri');
    }
}
