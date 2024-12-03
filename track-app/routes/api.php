<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\TrackRequestDataJob;
use App\Http\Controllers\RequestDataController;


Route::get('/redirect', function (Request $request) {
    $url = $request->query('url'); // Retrieve 'url' query parameter
    Log::channel("stdout")->info($url);

    // Get client IP address
    $ipAddress = $request->ip();

    // Extract headers for device and OS detection
    $userAgent = $request->header('User-Agent');
    $referrer = $request->header('Referer', 'N/A');
    $languages = $request->header('Accept-Language');
    $fullUrl = $request->fullUrl();

    // Parse user-agent (custom parsing or libraries like Jenssegers Agent can be used here)
    $os = $userAgent; // Simplified for demonstration
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

    //// Dispatch the job to handle this data
    TrackRequestDataJob::dispatch($data);

    // Ensure the 'url' parameter exists and is valid
    if (!$url || $url == '') {
        return response()->json(['error' => 'Invalid or missing URL'], 400);
    }

    return redirect($url);
});


Route::get('/requests', [RequestDataController::class, 'index']);

