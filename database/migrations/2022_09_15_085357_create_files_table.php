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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('relation_type');
            $table->unsignedBigInteger('relation_id');
            $table->unsignedBigInteger('directory_id')->nullable();
            $table->string('name')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->string('full_path')->nullable();
            $table->double('file_size')->unsigned()->nullable();
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
        Schema::dropIfExists('files');
    }
};
