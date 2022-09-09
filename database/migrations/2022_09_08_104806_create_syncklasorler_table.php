<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncklasorlerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syncklasorler', function (Blueprint $table) {
            $table->string('ID', 250)->primary()->unique();
            $table->string('FIRMAAPIKEY', 250)->nullable();
            $table->string('KULLANICIAPIKEY', 250)->nullable();
            $table->string('KLASORADI', 250)->nullable();
            $table->string('KAYNAKADI', 250)->nullable();
            $table->string('KAYNAKBILGISAYARADI', 250)->nullable();
            $table->string('KAYNAKKLASORYOLU', 250)->nullable();
            $table->integer('AKTIF')->nullable();
            $table->string('DOSYAFILITRE', 2000)->nullable();
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
        Schema::dropIfExists('syncklasorler');
    }
}
