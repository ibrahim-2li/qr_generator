<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\Scan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class QrCodeController extends Controller
{
    use AuthorizesRequests;

    public function sh(Request $request, QrCode $qr)
    {
        // $this->authorize('view', $qr);

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

        // Get country (you might want to use a GeoIP service for this)
        $country = $this->getCountryFromIp($ip);

        // Create scan record
        Scan::create([
            'qr_code_id' => $qr->id,
            'ip' => $ip,
            'country' => $country,
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
     * Get country from IP address
     * Note: This is a basic implementation. For production, consider using a GeoIP service
     */
    private function getCountryFromIp(string $ip): ?string
    {
        // For localhost/development
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Local';
        }

        // Basic implementation - you might want to integrate with a GeoIP service
        // like MaxMind, IPinfo, or similar for production use
        return null;
    }

    public function downloadVcard(QrCode $qr)
    {
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

        // Add social media links
        // if ($content->linkedin) {
        //     $vcard .= "URL;TYPE=LinkedIn:" . $content->linkedin . "\n";
        // }

        // if ($content->x) {
        //     $vcard .= "URL;TYPE=Twitter:" . $content->x . "\n";
        // }

        // if ($content->facebook) {
        //     $vcard .= "URL;TYPE=Facebook:" . $content->facebook . "\n";
        // }

        // if ($content->instagram) {
        //     $vcard .= "URL;TYPE=Instagram:" . $content->instagram . "\n";
        // }

        // if ($content->youtube) {
        //     $vcard .= "URL;TYPE=YouTube:" . $content->youtube . "\n";
        // }

        $vcard .= 'END:VCARD';

        // Generate filename (sanitize for filesystem)
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $content->name).'_contact.vcf';

        // Return file download response
        return response($vcard)
            ->header('Content-Type', 'text/vcard; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
