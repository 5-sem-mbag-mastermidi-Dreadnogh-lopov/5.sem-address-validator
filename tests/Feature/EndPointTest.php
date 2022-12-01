<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProviderTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_the_application_returns_a_successful_response_to_api_v1_alive()
    {
        $response = $this->get('/api/alive');

        $response->assertStatus(200);
    }
    public function test_the_application_returns_a_bad_response_to_api_v1_login()
    {
        $response = $this->get('/api/v1/login?password=test');

        $response->assertStatus(401);
    }
    public function test_the_application_returns_a_successful_response_to_api_v1_login()
    {
        $response = $this->get('/api/v1/login?password=' . env('APP_PASSWORD'));

        $response->assertStatus(200);
        // check if jwt is set
    }
}
