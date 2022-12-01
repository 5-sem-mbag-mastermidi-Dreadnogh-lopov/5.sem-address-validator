<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleSeedTest extends TestCase
{
    //Runs migration on each test, to refresh data.
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_seed_example()
    {
       //Creates all seed data from DatabaseSeeder by default
       $this->seed();

       //Test that there is one entry in hash request
       $this->assertDatabaseCount('hash_request', 2);

       //Test that there is one entry in address
       $this->assertDatabaseCount('address', 2);
    }
}
