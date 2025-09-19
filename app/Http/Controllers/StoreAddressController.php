<?php

namespace App\Http\Controllers;

use App\Models\StoreAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreAddressController extends Controller
{
    public function index()
    {
        $addresses = StoreAddress::where('admin_id', auth('admin')->id())->get();
        return view('admin.store_address.index', compact('addresses'));
    }

    public function create()
    {
        // Cek apakah admin sudah punya alamat toko
        $existingAddress = StoreAddress::where('admin_id', auth('admin')->id())->first();
        
        return view('admin.store_address.create', compact('existingAddress'));
    }

    public function store(Request $request)
    {
        // Cek apakah admin sudah punya alamat toko
        $adminId = auth('admin')->id();
        $existingAddress = StoreAddress::where('admin_id', $adminId)->first();
        
        if ($existingAddress) {
            return redirect()->route('store-address.create')
                ->with('error', 'Anda sudah memiliki alamat toko. Silakan edit alamat yang sudah ada.');
        }

        Log::info('StoreAddressController@store request:', $request->all());

        $request->validate([
            'alamat_lengkap' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'ongkir_per_1km' => 'required|numeric|min:0',
        ]);

        Log::info('Admin yang login:', ['admin_id' => $adminId]);

        try {
            $storeAddress = StoreAddress::create([
                'admin_id' => $adminId,
                'alamat_lengkap' => $request->alamat_lengkap,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'ongkir_per_km' => $request->ongkir_per_1km,
            ]);

            Log::info('Alamat toko berhasil dibuat', $storeAddress->toArray());

            return redirect()->route('store-address.create')
                ->with('success', 'Alamat toko berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan alamat toko', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Gagal menambahkan alamat toko: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $address = StoreAddress::where('admin_id', auth('admin')->id())
                               ->where('id', $id)
                               ->firstOrFail();
        return view('admin.store_address.show', compact('address'));
    }

    public function edit($id)
    {
        $address = StoreAddress::where('admin_id', auth('admin')->id())
                               ->where('id', $id)
                               ->firstOrFail();
        return view('admin.store_address.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        Log::info('StoreAddressController@update request:', $request->all());

        $address = StoreAddress::where('admin_id', auth('admin')->id())
                               ->where('id', $id)
                               ->firstOrFail();

        $request->validate([
            'alamat_lengkap' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'ongkir_per_1km' => 'required|numeric|min:0',
        ]);

        try {
            $address->update([
                'alamat_lengkap' => $request->alamat_lengkap,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'ongkir_per_km' => $request->ongkir_per_1km,
            ]);

            Log::info('Alamat toko berhasil diupdate', $address->toArray());

            return redirect()->route('store-address.create')
                ->with('success', 'Alamat toko berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate alamat toko', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Gagal memperbarui alamat toko: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Log::info('StoreAddressController@destroy request:', ['id' => $id]);

        $address = StoreAddress::where('admin_id', auth('admin')->id())
                               ->where('id', $id)
                               ->firstOrFail();

        try {
            $address->delete();

            Log::info('Alamat toko berhasil dihapus', ['id' => $id]);

            return redirect()->route('store-address.create')
                ->with('success', 'Alamat toko berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus alamat toko', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Gagal menghapus alamat toko: ' . $e->getMessage());
        }
    }
}