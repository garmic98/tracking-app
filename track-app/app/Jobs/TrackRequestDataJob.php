<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\RequestDataController;
use App\Utils\Functions;

class TrackRequestDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $ipAddress = $this->data['ip_address'];

        if($ipAddress == "127.0.0.1") // if localhost -> use more interesting IP
        {
            $ipAddress = "142.251.211.227";
        }

        $response = Http::get("http://ip-api.com/json/{$ipAddress}");

        $parsedAgent = Functions::parseUserAgent($this->data['user_agent']);
        $this->data['os'] = $parsedAgent["os"];
        $this->data['device'] = $parsedAgent["device"];


        if ($response->successful()) {
            $this->data['location']['lat'] = $response["lat"];
            $this->data['location']['long'] = $response['lon'];
        } else {
            Log::error("Failed to get location data for IP {$ipAddress}");
        }
        (new RequestDataController())->storeRequestData($this->data);
    }
}
