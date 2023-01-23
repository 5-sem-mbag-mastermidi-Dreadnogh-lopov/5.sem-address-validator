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
        Schema::create('hash_request', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('hash_key')->unique();
            $table->jsonb('request');

            $table->foreignId('address_id')->references('id')->on('address')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hash_request');
    }
};
