<?php

use Illuminate\Support\Str;

if (!function_exists('generateRandomSku')) {
    function generateRandomSku($prefix = '', $length = 8)
    {
        $randomPart = strtoupper(Str::random($length));
        return $prefix ? strtoupper($prefix) . '-' . $randomPart : $randomPart;
    }
}
