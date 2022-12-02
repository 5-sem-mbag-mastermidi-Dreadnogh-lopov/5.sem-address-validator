<?php

use App\Models\AddressRequest;
use Illuminate\Http\Request;
use \Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CacheControllerTest extends  TestCase
{
    use RefreshDatabase;

    public function success_should_return_address()
    {

            $this->seed();

            $request = new Request([ "search_field" => "FyrKildevej",]);

            $result =  (new App\Http\Controllers\CacheController)->index($request)->toArray();

            $this->assertNotNull($result);
            expect($result[0])->toMatchArray(['address_formatted' => 'Fyrkildevej 104, 1. tv, 9220 Aalborg']);

    }

    public function success_should_update_address()
    {

        $this->seed();

        $id = "1";

        $request_update = new Request(['address_formatted' => 'test']);

        (new App\Http\Controllers\CacheController)->update($request_update, $id);

        $request = new Request(['search_field' => 'test']);

        $result = (new App\Http\Controllers\CacheController)->index($request);

        $this->assertNotNull($result);
        expect($result[0])->toMatchArray(['address_formatted' => 'test']);

    }

    public function success_should_delete_address()
    {

        $this->seed();

        $id = "1";

        $request = new Request([ ]);

        (new App\Http\Controllers\CacheController)->delete($id);

        $count = (new App\Http\Controllers\CacheController)->index($request)->count();

        expect($count)->toBeLessThan(2);

    }


}

