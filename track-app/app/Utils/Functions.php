<?php
namespace App\Utils;

class Functions{
    static function parseUserAgent($userAgent)
    {
        // Initialize default values
        $os = 'Unknown OS';
        $device = 'Unknown Device';

        // Define patterns for OS detection
        $osPatterns = [
            '/windows nt 10/i'     => 'Windows 10',
            '/windows nt 6.3/i'    => 'Windows 8.1',
            '/windows nt 6.2/i'    => 'Windows 8',
            '/windows nt 6.1/i'    => 'Windows 7',
            '/windows nt 6.0/i'    => 'Windows Vista',
            '/windows nt 5.1/i'    => 'Windows XP',
            '/macintosh|mac os x/i'=> 'Mac OS X',
            '/mac_powerpc/i'       => 'Mac OS 9',
            '/linux/i'             => 'Linux',
            '/iphone/i'            => 'iOS',
            '/ipad/i'              => 'iPadOS',
            '/android/i'           => 'Android',
            '/blackberry/i'        => 'BlackBerry',
            '/webos/i'             => 'Mobile WebOS'
        ];

        // Define patterns for device type detection
        $devicePatterns = [
            '/mobile/i'    => 'Mobile',
            '/tablet/i'    => 'Tablet',
            '/desktop/i'   => 'Desktop',
            '/iphone|ipad/i' => 'Mobile', // Apple devices categorized as mobile
            '/android/i'   => 'Mobile',
            '/windows/i'   => 'PC',
        ];

        // Detect OS
        foreach ($osPatterns as $pattern => $name) {
            if (preg_match($pattern, $userAgent)) {
                $os = $name;
                break;
            }
        }

        // Detect Device Type
        foreach ($devicePatterns as $pattern => $type) {
            if (preg_match($pattern, $userAgent)) {
                $device = $type;
                break;
            }
        }

        return [
            'os' => $os,
            'device' => $device
        ];
    }
}
