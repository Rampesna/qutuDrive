<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersiyontakipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versiyontakip', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->integer('TURKODU')->nullable();
            $table->integer('VERSIYON')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versiyontakip');
    }
}
