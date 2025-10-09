<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\Scan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class QrCodeController extends Controller
{
    use AuthorizesRequests;

    public function sh(Request $request, QrCode $qr)
    {
        // Check if QR code is active (user has subscription or is on trial)
        if (!$qr->user->qrCodesShouldBeActive()) {
            return view('qr.expired', compact('qr'));
        }

        // Track the scan
        $this->trackScan($request, $qr);

        return view('qr.sh', compact('qr'));
    }

    /**
     * Track QR code scan and increment scan count
     */
    private function trackScan(Request $request, QrCode $qr): void
    {
        $sessionKey = "qr_scanned_{$qr->id}";

        // Check if this session has already scanned this QR code
        if ($request->session()->has($sessionKey)) {
            return;
        }

        $ip = $request->ip();

        // Double-check with IP-based deduplication (within last 30 minutes)
        // This helps in cases where sessions might not work properly
        $recentScan = Scan::where('qr_code_id', $qr->id)
            ->where('ip', $ip)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->exists();

        if ($recentScan) {
            // Mark in session to prevent future checks
            $request->session()->put($sessionKey, true);

            return;
        }

        $agent = new Agent;
        $agent->setUserAgent($request->userAgent());

        // Get device information
        $device = $this->getDeviceType($agent);
        $os = $agent->platform();

        // Get location information (you might want to use a GeoIP service for this)
        $location = $this->getLocationFromIp($ip);

        // Create scan record
        Scan::create([
            'qr_code_id' => $qr->id,
            'ip' => $ip,
            'country' => $location['country'],
            'region' => $location['region'],
            'city' => $location['city'],
            'device' => $device,
            'os' => $os,
        ]);

        // Increment scan count
        $qr->increment('scan_count');

        // Mark this QR code as scanned in the session
        $request->session()->put($sessionKey, true);
    }

    /**
     * Get device type from user agent
     */
    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'Mobile';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isDesktop()) {
            return 'Desktop';
        } elseif ($agent->isRobot()) {
            return 'Bot';
        }

        return 'Unknown';
    }

    /**
     * Get location information from IP address
     * Note: This is a basic implementation. For production, consider using a GeoIP service
     */
    private function getLocationFromIp(string $ip): array
    {
        // For localhost/development
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return [
                'country' => 'Local',
                'region' => 'Local',
                'city' => 'Local'
            ];
        }

        // Try to get location from IP using free services
        try {
            // Using ipapi.co (free tier: 1000 requests/day)
            $response = Http::timeout(5)->get("http://ipapi.co/{$ip}/json/");

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'country' => $data['country_name'] ?? null,
                    'region' => $data['region'] ?? null,
                    'city' => $data['city'] ?? null
                ];
            }
        } catch (\Exception $e) {
            // Fallback to another service or return null values
        }

        // Try alternative service (ip-api.com)
        try {
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}");

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'region' => $data['regionName'] ?? null,
                        'city' => $data['city'] ?? null
                    ];
                }
            }
        } catch (\Exception $e) {
            // Continue to fallback
        }

        // Fallback: return null values
        return [
            'country' => null,
            'region' => null,
            'city' => null
        ];
    }

    public function downloadVcard(QrCode $qr)
    {
        // Check if QR code is active
        if (!$qr->user->qrCodesShouldBeActive()) {
            abort(403, 'This QR code is no longer active. Please subscribe to continue using this feature.');
        }

        $content = $qr->content;

        // Generate vCard content
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= 'FN:'.$content->name."\n";
        $vcard .= 'N:'.$content->name.";;;;\n";

        if ($content->phone) {
            $vcard .= 'TEL;TYPE=CELL:'.$content->phone."\n";
        }

        if ($content->email) {
            $vcard .= 'EMAIL;TYPE=INTERNET:'.$content->email."\n";
        }

        if ($content->company) {
            $vcard .= 'ORG:'.$content->company."\n";
        }

        $vcard .= 'END:VCARD';

        // Generate filename (sanitize for filesystem)
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $content->name).'_contact.vcf';

        // Return file download response
        return response($vcard)
            ->header('Content-Type', 'text/vcard; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
