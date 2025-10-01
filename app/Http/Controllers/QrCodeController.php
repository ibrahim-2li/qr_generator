<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrContent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QrCodeController extends Controller
{
    use AuthorizesRequests;


    public function sh(QrCode $qr)
    {
        // $this->authorize('view', $qr);
        return view('qr.sh', compact('qr'));
    }


    public function downloadVcard(QrCode $qr)
    {
        $content = $qr->content;

        // Generate vCard content
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "FN:" . $content->name . "\n";
        $vcard .= "N:" . $content->name . ";;;;\n";

        if ($content->phone) {
            $vcard .= "TEL;TYPE=CELL:" . $content->phone . "\n";
        }

        if ($content->email) {
            $vcard .= "EMAIL;TYPE=INTERNET:" . $content->email . "\n";
        }

        if ($content->company) {
            $vcard .= "ORG:" . $content->company . "\n";
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

        $vcard .= "END:VCARD";

        // Generate filename (sanitize for filesystem)
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $content->name) . '_contact.vcf';

        // Return file download response
        return response($vcard)
            ->header('Content-Type', 'text/vcard; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
