<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WilayahController extends Controller
{
    private $apiKey = 'dc7fda0fdc996938db55062a320dfde1f3ed9d674988db4f3475059a213b928c';
    private $baseUrl = 'https://api.binderbyte.com/wilayah';

    public function getProvinsi()
    {
        $res = Http::get($this->baseUrl . '/provinsi', [
            'api_key' => $this->apiKey
        ]);
    
        $json = $res->json();
    
        if (isset($json['value']) && is_array($json['value'])) {
            return response()->json([
                'code' => 200,
                'data' => $json['value'],
            ]);
        }
    
        return response()->json([
            'code' => 400,
            'message' => 'Data tidak ditemukan',
        ]);
    }
    

    public function getKota($provinsiId)
    {
        $res = Http::get($this->baseUrl . '/kabupaten', [
            'id_provinsi' => $provinsiId,
            'api_key' => $this->apiKey,
        ]);
    
        $json = $res->json();
    
        if (isset($json['value']) && is_array($json['value'])) {
            return response()->json([
                'code' => 200,
                'data' => $json['value'],
            ]);
        }
    
        return response()->json([
            'code' => 400,
            'message' => 'Data tidak ditemukan',
        ]);
    }
    
    public function getKecamatan($kabupatenId)
    {
        $res = Http::get($this->baseUrl . '/kecamatan', [
            'id_kabupaten' => $kabupatenId,  // Ubah 'id_kota' jadi 'id_kabupaten'
            'api_key' => $this->apiKey
        ]);
        $json = $res->json();
    
        if (isset($json['value']) && is_array($json['value'])) {
            return response()->json([
                'code' => 200,
                'data' => $json['value'],  // Sesuaikan ambil data dari key 'value'
            ]);
        }
    
        return response()->json([
            'code' => 400,
            'message' => 'Data tidak ditemukan',
        ]);
    }
    

    public function getDesa($kecamatanId)
    {
        // Debug: log parameter
        Log::info('Request desa id_kecamatan: ' . $kecamatanId);
    
        $res = Http::get($this->baseUrl . '/kelurahan', [
            'id_kecamatan' => $kecamatanId,
            'api_key' => $this->apiKey
        ]);
        $json = $res->json();
    
        Log::info('Response desa: ', $json);
    
        if (isset($json['value']) && is_array($json['value'])) {
            return response()->json([
                'code' => 200,
                'data' => $json['value'],
            ]);
        }
    
        return response()->json([
            'code' => 400,
            'message' => 'Data tidak ditemukan',
        ]);
    }
    
}
