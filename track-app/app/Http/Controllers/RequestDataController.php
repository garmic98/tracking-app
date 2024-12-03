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
            'ip_address' => $data['ip_address'],
            'operating_system' => $data['os'],
            'device' => $data['device'],
            'referrer' => $data['referrer'],
            'url' => $data['url'],
            'language' => $data['language'],
            'latitude' => $data['location']['lat'] ?? null,
            'longitude' => $data['location']['long'] ?? null,
        ]);
        return response()->json(['message' => 'Data stored successfully!', 'data' => $requestData], 201);
    }
}
