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
        DB::statement('create view dao_address_view as select id, concat(gadenavn_synonym, \' \', hus_nr, opgang) as address_formatted, post_nr from dao_address;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::statement('drop view IF EXISTS dao_address_view');
    }
};
