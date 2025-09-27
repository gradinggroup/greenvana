<?php

namespace App\Http\Controllers;

use App\Models\GameUpload;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{


public function index()
{


    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Silakan login untuk bermain game');
    }

    

    $todayCount = GameUpload::where('user_id', $user->id)
        ->whereDate('created_at', now()->toDateString())
        ->count();

    if ($todayCount >= 3) {
        return redirect()->back()->with('error', 'Anda sudah bermain maksimal 3 kali sehari');
    }

    return view('frontend.game');
}



    public function upload(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login.'
            ], 401);
        }

        $limit = 3;
        $today = now()->timezone(config('app.timezone'))->toDateString();

        // hitung jumlah upload hari ini
        $countToday = GameUpload::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->count();

        if ($countToday >= $limit) {
            return response()->json([
                'success'   => false,
                'message'   => "Batas main hari ini tercapai ($limit/$limit). Coba lagi besok.",
                'limit'     => $limit,
                'used'      => $countToday,
                'remaining' => 0,
            ], 429);
        }

        // simpan entry baru (tanpa order_id)
        $upload = GameUpload::create([
            'user_id' => $userId,
            // tambahkan field lain jika ada, misal skor, hadiah, dsb
        ]);

        $remaining = $limit - ($countToday + 1);

        return response()->json([
            'success'   => true,
            'message'   => "Data tersimpan. Sisa kesempatan hari ini: {$remaining}.",
            'limit'     => $limit,
            'used'      => $countToday + 1,
            'remaining' => $remaining,
            'data'      => $upload,
        ]);
    }




}
