<?php

use App\Models\Account;
use App\Models\CashIn;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('numberFormat')) {
    function numberFormat($number, $prefix = null)
    {
        if (isset($prefix)) {
            return $prefix. ' ' . number_format($number, 0, ',', '.');
        }
        return number_format($number, 0, ',', '.');
    }
}

if (!function_exists('replaceRupiah')) {
    function replaceRupiah(string $rupiah)
    {
        $rupiah = Str::replace('Rp. ', '', $rupiah);
        return (int) Str::replace('.', '', $rupiah);
    }
}

if (!function_exists('generateNoCek')) {
    function generateNoCek()
    {
        $thnBulan = Carbon::now()->year . Carbon::now()->month;
        if (CashIn::count() === 0) {
            return 'NC' . $thnBulan . '10000001';
        } else {
            return 'NC' . $thnBulan . (int) substr(CashIn::get()->last()->no_cek, -8) + 1;
        }
    }
}
