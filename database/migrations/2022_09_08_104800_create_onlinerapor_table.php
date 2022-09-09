<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineraporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlinerapor', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->dateTime('SUNUCUTARIH')->nullable();
            $table->integer('SUNUCUSAAT')->nullable();
            $table->dateTime('LOCALTARIH')->nullable();
            $table->integer('LOCALSAAT')->nullable();
            $table->string('LOCALIP', 250)->nullable();
            $table->string('DISIP', 250)->nullable();
            $table->string('BILGISAYARADI', 250)->nullable();
            $table->string('WINDOWSKULLANICIADI', 250)->nullable();
            $table->integer('UYGULAMATURU')->nullable();
            $table->integer('UYGULAMAVERSIYON')->nullable();
            $table->integer('DBVERSIYON')->nullable();
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
        Schema::dropIfExists('onlinerapor');
    }
}
