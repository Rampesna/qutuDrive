<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDilekcelerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dilekceler', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->integer('TUR')->nullable();
            $table->string('DEGER', 250)->nullable();
            $table->string('ACIKLAMA', 250)->nullable();
            $table->string('ISLEMIYAPANKULLANICI', 250)->nullable();
            $table->longText('DILEKCEYOLU')->nullable();
            $table->dateTime('TARIH')->nullable();
            $table->string('GUID', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dilekceler');
    }
}
