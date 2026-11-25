<?php

namespace App\Support;

class Img
{
    /**
     * Local photos that ship with the site (from the Zenith template).
     * Used directly, and as the fallback when a remote photo cannot load.
     */
    public const LOCAL = [
        'hero' => 'images/photos/hero-residence.jpg',
        'feature' => 'images/photos/feature-villa.jpg',
        'coastal' => 'images/photos/residence-coastal.jpg',
        'pool' => 'images/photos/residence-pool.jpg',
        'alpine' => 'images/photos/residence-alpine.jpg',
    ];

    /**
     * Accepts an Unsplash photo id ("photo-..."), a full URL, or a path under /public.
     */
    public static function url(?string $src, int $width = 1600): ?string
    {
        if (! $src) {
            return null;
        }
        if (str_starts_with($src, 'photo-')) {
            return 'https://images.unsplash.com/'.$src.'?'.http_build_query(['auto' => 'format', 'fit' => 'crop', 'w' => $width, 'q' => 80]);
        }
        if (str_starts_with($src, 'http')) {
            return $src;
        }

        return asset(ltrim($src, '/'));
    }

    public static function isRemote(?string $src): bool
    {
        return $src && (str_starts_with($src, 'photo-') || str_starts_with($src, 'http'));
    }

    /** A local stand-in for a remote photo, picked consistently from its id. */
    public static function fallback(?string $src): string
    {
        // The hero photo has a white sky built in, so it is not used as a stand-in.
        $keys = array_values(array_diff_key(self::LOCAL, ['hero' => true]));

        return asset($keys[crc32((string) $src) % count($keys)]);
    }
}
