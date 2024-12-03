<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestData;

class RequestDataController extends Controller
{
    public function index()
    {
        $requestData = RequestData::all();
        return response()->json(['data' => $requestData], 200);
    }


    public function storeRequestData(array $data)
    {
        $requestData = RequestData::create([
            'ip_address' => $data['IP_Address'],
            'operating_system' => $data['Operating_System'],
            'device' => $data['Device'],
            'referrer' => $data['Referrer'],
            'url' => $data['URL'],
            'language' => $data['Language'],
            'latitude' => $data['Location']['Latitude'] ?? null,
            'longitude' => $data['Location']['Longitude'] ?? null,
        ]);
        return response()->json(['message' => 'Data stored successfully!', 'data' => $requestData], 201);
    }
}
