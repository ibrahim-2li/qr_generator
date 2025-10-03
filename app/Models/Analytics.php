<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Analytics extends Model
{
    protected $fillable = [];

    /**
     * Get total QR codes count
     */
    public static function getTotalQrCodes(): int
    {
        return QrCode::count();
    }

    /**
     * Get total scans count
     */
    public static function getTotalScans(): int
    {
        return Scan::count();
    }

    /**
     * Get unique scans count (by IP)
     */
    public static function getUniqueScans(): int
    {
        return Scan::distinct('ip')->count();
    }

    /**
     * Get scan trends for the last N days
     */
    public static function getScanTrends(int $days = 30): array
    {
        return Scan::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as scans')
        )
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get scans by operating system
     */
    public static function getScansByOs(): array
    {
        return Scan::select('os', DB::raw('COUNT(*) as count'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->get()
            ->toArray();
    }

    /**
     * Get scans by country
     */
    public static function getScansByCountry(int $limit = 10): array
    {
        return Scan::select('country', DB::raw('COUNT(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get scans by device type
     */
    public static function getScansByDevice(): array
    {
        return Scan::select('device', DB::raw('COUNT(*) as count'))
            ->whereNotNull('device')
            ->groupBy('device')
            ->get()
            ->toArray();
    }
}
