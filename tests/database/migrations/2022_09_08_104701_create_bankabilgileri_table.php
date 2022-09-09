<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankabilgileriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankabilgileri', function (Blueprint $table) {
            $table->integer('ID')->primary();
            $table->string('BAYIKODU', 45)->nullable();
            $table->string('HESAPSAHIBI', 250)->nullable();
            $table->string('BANKAADI', 250)->nullable();
            $table->string('IBAN', 250)->nullable();
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
        Schema::dropIfExists('bankabilgileri');
    }
}
