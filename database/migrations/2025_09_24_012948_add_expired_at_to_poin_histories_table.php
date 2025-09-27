<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('poin_histories', function (Blueprint $table) {
            $table->timestamp('expired_at')->nullable()->after('jumlah');
            $table->index('expired_at');
        });
    }

    public function down(): void
    {
        Schema::table('poin_histories', function (Blueprint $table) {
            $table->dropIndex(['expired_at']);
            $table->dropColumn('expired_at');
        });
    }
};
