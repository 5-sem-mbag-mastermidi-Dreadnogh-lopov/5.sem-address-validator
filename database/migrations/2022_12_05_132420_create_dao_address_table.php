<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dao_address', function (Blueprint $table) {
            $table->string('post_nr');
            $table->string('post_distrikt');
            $table->string('gadenavn');
            $table->string('gadenavn_synonym');
            $table->string('hus_nr');
            $table->string('opgang');
            $table->integer('x_koordinat');
            $table->integer('y_koordinat');
            $table->float('LAENGDEGRAD');
            $table->float('BREDDEGRAD');
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
