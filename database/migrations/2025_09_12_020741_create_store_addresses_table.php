<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('store_addresses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade'); // relasi ke tabel admins
        $table->string('alamat_lengkap');
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);
        $table->decimal('ongkir_per_km', 10, 2);
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('store_addresses');
    }
};
