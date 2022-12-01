<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AddressSeeder::class,
            AddressRequestSeeder::class,
        ]);
    }


    //\App\Models\User::factory(10)->create();

    //\App\Models\AddressRequest::factory()->create([
    //   'street' => 'Urbansgade',
    //   'state' => 'Danmark',
    //   'zip_code' => '9000',
    //   'city' => 'Aalborg',
    //   'country_code' => 'DK'
    //]);
}
