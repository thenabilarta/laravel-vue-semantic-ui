<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Media extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('media_id');
            $table->string('name');
            $table->string('stored_as');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('retired');
            $table->string('size');
            $table->string('type');
            $table->string('tags')->nullable();
            $table->string('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}