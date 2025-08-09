<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id']);

            // Tambah kolom baru
            $table->string('provinsi')->nullable()->after('name');
            $table->string('kabupaten_kota')->nullable()->after('provinsi');
            $table->string('kecamatan')->nullable()->after('kabupaten_kota');
            $table->string('kelurahan_desa')->nullable()->after('kecamatan');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Balikin kolom lama
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();

            // Hapus kolom baru
            $table->dropColumn(['provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa']);
        });
    }
};
