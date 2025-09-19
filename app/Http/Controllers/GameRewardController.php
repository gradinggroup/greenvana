<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PoinUser;
use App\Models\PoinHistory;
use App\Models\Voucher;
use Illuminate\Support\Facades\Log;

class GameRewardController extends Controller
{
    /**
     * Simpan reward dari game (poin + voucher)
     */
public function simpanReward(Request $request)
{
    try {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login.'
            ], 401);
        }

        $user = Auth::user();

        // Random reward
        $points = rand(3, 10);
        $voucherNominal = rand(2000, 10000);

        // Update / buat total poin user
        $poinUser = PoinUser::firstOrCreate(
            ['user_id' => $user->id],
            ['total_poin' => 0]
        );

        $poinUser->increment('total_poin', $points);

        // Simpan riwayat poin
        PoinHistory::create([
            'user_id' => $user->id,
            'jumlah' => $points,
            'jenis' => 'penambahan',
            'keterangan' => 'Reward dari game',
        ]);

        // Simpan voucher baru
        $voucher = Voucher::create([
            'user_id' => $user->id,
            'nominal' => $voucherNominal,
            'status' => 'aktif',
        ]);

        return response()->json([
            'success' => true,
            'poin_didapat' => $points,
            'voucher_nominal' => $voucher->nominal,
            'total_poin' => $poinUser->total_poin,
            'message' => 'Reward berhasil disimpan.'
        ]);

    } catch (\Exception $e) {
        Log::error("Error di GameRewardController@simpanReward: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi error: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Ambil semua voucher milik user login
     */
    public function listVoucher()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login.'
            ], 401);
        }

        $user = Auth::user();
        $vouchers = Voucher::where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'vouchers' => $vouchers
        ]);
    }

    /**
     * Ambil total poin + history user login
     */
    public function poinSaya()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login.'
            ], 401);
        }

        $user = Auth::user();
        $poinUser = PoinUser::where('user_id', $user->id)->first();
        $histories = PoinHistory::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'total_poin' => $poinUser ? $poinUser->total_poin : 0,
            'histories' => $histories
        ]);
    }
}
