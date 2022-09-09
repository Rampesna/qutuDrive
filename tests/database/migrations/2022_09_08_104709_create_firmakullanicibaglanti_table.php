<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmakullanicibaglantiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmakullanicibaglanti', function (Blueprint $table) {
            $table->bigInteger('ID')->primary();
            $table->bigInteger('FIRMAID')->nullable();
            $table->bigInteger('KULLANICIID')->nullable();
            $table->text('FIRMAUNVAN')->nullable();
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
        Schema::dropIfExists('firmakullanicibaglanti');
    }
}
