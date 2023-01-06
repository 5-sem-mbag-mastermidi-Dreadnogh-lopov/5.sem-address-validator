<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            //code...
            DB::statement('CREATE EXTENSION fuzzystrmatch;');
        } catch (\Throwable $th) {
            //throw $th;
        }   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extension_fuzzystrmatch');
    }
};
