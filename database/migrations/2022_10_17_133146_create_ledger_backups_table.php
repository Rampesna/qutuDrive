<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->string('yevmiye_defteri')->nullable();
            $table->string('kebir_defteri')->nullable();
            $table->string('yevmiye_beratı')->nullable();
            $table->string('kebir_beratı')->nullable();
            $table->string('gib_yevmiye_beratı')->nullable();
            $table->string('gib_kebir_defteri')->nullable();
            $table->string('defter_raporu')->nullable();
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
        Schema::dropIfExists('ledger_backups');
    }
};
