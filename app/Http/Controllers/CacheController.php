<?php

namespace App\Http\Controllers;

use App\Models\AddressResponse;
use App\Models\HashRequest;
use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function index()
    {
        return AddressResponse::paginate(15);
    }

    public function get($id)
    {
        return AddressResponse::where('id', $id)->first();
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
