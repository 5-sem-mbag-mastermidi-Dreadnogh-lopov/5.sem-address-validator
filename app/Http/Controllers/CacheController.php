<?php

namespace App\Http\Controllers;

use App\Models\AddressResponse;
use App\Models\HashRequest;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function index(Request $request)
    {
        if($request->search_field){
            return AddressResponse::where('address_formatted', "LIKE", "$request->search_field%")->get();

        }
        return AddressResponse::all('id', $id);
    }

    public function delete($id)
    {
        $hash_request = AddressResponse::find($id);
        $hash_request->delete();
    }

    public function update(Request $request, $id)
    {
        return AddressResponse::where('id', $id)->update($request->all());
    }
}
