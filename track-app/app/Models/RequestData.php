<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestData extends Model
{
    use HasFactory;

    protected $table = 'request_data';

    protected $fillable = [
        'ip_address',
        'operating_system',
        'device',
        'referrer',
        'url',
        'language',
        'latitude',
        'longitude',
    ];
}
