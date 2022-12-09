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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('confidence');
            $table->string('address_formatted');
            $table->string('street_name');
            $table->string('street_number');
            $table->string('zip_code');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country_code');
            $table->string('country_name');
            $table->float('latitude');
            $table->float('longitude');
            $table->boolean('mainland');
            $table->dateTime('expire_date')->nullable();

            $table->jsonb('response_json');

            $table->unique(['street_name', 'street_number', 'zip_code'], 'unique_address');
        });

        if (env('APP_ENV') != "testing")
            DB::statement("ALTER TABLE address ALTER COLUMN expire_date SET DEFAULT now() + interval '100 day';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_address');
    }
};
