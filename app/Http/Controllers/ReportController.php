<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // === ANALISIS SENTIMEN RATING ===
        $sentimen = DB::table('reviews')
            ->selectRaw("
                SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) as positif,
                SUM(CASE WHEN rating = 3  THEN 1 ELSE 0 END) as netral,
                SUM(CASE WHEN rating <= 2 THEN 1 ELSE 0 END) as negatif
            ")
            ->first();

        // === INFO KUPON ===
        $now = Carbon::now();

        $kuponAktif = DB::table('coupons')
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', $now);
            })
            ->count();

        $kuponKadaluarsa = DB::table('coupons')
            ->where('expires_at', '<=', $now)
            ->count();

        $totalPenggunaan = DB::table('coupons')
            ->sum('used_count');

        // === RATING PER BINTANG (untuk grafik bar) ===
        $ratingPerBintang = DB::table('reviews')
            ->selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        return view('laporan.index', compact(
            'sentimen',
            'kuponAktif',
            'kuponKadaluarsa',
            'totalPenggunaan',
            'ratingPerBintang'
        ));
    }
}