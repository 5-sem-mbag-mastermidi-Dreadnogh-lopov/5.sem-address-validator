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
        Schema::create('dao_address', function (Blueprint $table) {
            $table->id();
            $table->string('post_nr')->nullable();
            $table->string('post_distrikt')->nullable();
            $table->string('gadenavn')->nullable();
            $table->string('gadenavn_synonym')->nullable();
            $table->string('hus_nr')->nullable();
            $table->string('opgang')->nullable();
            $table->integer('x_koordinat')->nullable();
            $table->integer('y_koordinat')->nullable();
            $table->float('laengdegrad')->nullable();
            $table->float('breddegrad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dao_address');
    }
};
