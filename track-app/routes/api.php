<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\TrackRequestDataJob;
use App\Http\Controllers\RequestDataController;


Route::get('/redirect', function (Request $request) {
    $url = $request->query('url');
    Log::channel("stdout")->info($url);

    $ipAddress = $request->ip();

    //Header information
    $userAgent = $request->header('User-Agent');
    $referrer = $request->header('Referer', 'N/A');
    $languages = $request->header('Accept-Language');
    $fullUrl = $request->fullUrl();

    $os = $userAgent;
    $device = $userAgent;

    // Collect all data
    $data = [
        'DateTime' => now()->toDateTimeString(),
        'IP_Address' => $ipAddress,
        'Operating_System' => $os,
        'Device' => $device,
        'Referrer' => $referrer,
        'URL' => $fullUrl,
        'Language' => $languages,
        'Location' => [
            'Latitude' => 0,
            'Longitude' => 0,
        ],
    ];

    // Trigger the asynchronous job so that fetching and writing data to the database doesn't block the request
    TrackRequestDataJob::dispatch($data);

    // Ensure the 'url' parameter exists and is valid
    if (!$url || $url == '') {
        return response()->json(['error' => 'Invalid or missing URL'], 400);
    }

    return redirect($url);
});


Route::get('/requests', [RequestDataController::class, 'index']);

