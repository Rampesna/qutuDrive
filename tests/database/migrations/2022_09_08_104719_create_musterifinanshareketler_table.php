<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusterifinanshareketlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musterifinanshareketler', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->integer('MUSTERIID')->nullable();
            $table->dateTime('TARIH')->nullable();
            $table->integer('FISTURU')->nullable();
            $table->string('ACIKLAMA', 250)->nullable();
            $table->string('BELGENO', 45)->nullable();
            $table->float('TUTAR')->nullable();
            $table->integer('BA')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musterifinanshareketler');
    }
}
