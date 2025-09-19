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


public function index($order_id)
{
    $product = Order::findOrFail($order_id);

    $alreadyUploaded = GameUpload::where('order_id', $product->id)
        ->where('user_id', Auth::id())
        ->exists();

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

    return view('frontend.game', compact('product', 'alreadyUploaded'));
}



public function upload(Request $request)
{
    $request->validate([
        'order_id' => 'required',
        'user_id' => 'required',
    ]);

    // Cek apakah produk ini sudah di-upload
    $exists = GameUpload::where('order_id', $request->order_id)
        ->where('user_id', $request->user_id)
        ->first();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Produk ini sudah di-upload sebelumnya.'
        ], 409); // 409 Conflict
    }

    $upload = GameUpload::create([
        'order_id' => $request->order_id,
        'user_id' => $request->user_id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Foto berhasil di-upload!',
        'data' => $upload
    ]);
}




}
