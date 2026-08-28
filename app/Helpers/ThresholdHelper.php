<?php

namespace App\Helpers;

use App\Models\Setting;

class ThresholdHelper
{
    public static function getThresholds(): array
    {
        return [
            'kuning' => (int) Setting::where('key', 'threshold_kuning')->value('value') ?: 25,
            'merah'  => (int) Setting::where('key', 'threshold_merah')->value('value')  ?: 50,
            'hitam'  => (int) Setting::where('key', 'threshold_hitam')->value('value')  ?: 75,
        ];
    }

    public static function getLevel(int $totalPoin): string
    {
        $t = self::getThresholds();

        if ($totalPoin >= $t['hitam']) return 'hitam';
        if ($totalPoin >= $t['merah']) return 'merah';
        if ($totalPoin >= $t['kuning']) return 'kuning';
        return 'aman';
    }
}