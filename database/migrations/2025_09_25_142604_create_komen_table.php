<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            // Kolom FK (tanpa constrained() dulu)
            $table->unsignedBigInteger('products_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('name');
            $table->string('summary');
            $table->text('review');
            $table->unsignedTinyInteger('rating_quality');
            $table->unsignedTinyInteger('rating_price');
            $table->unsignedTinyInteger('rating_value');
            $table->decimal('rating_overall', 3, 2)->index();
            $table->timestamps();

            // Index (opsional; FK juga bikin index implicit, tapi ini memberi nama yang rapi)
            $table->index('product_id', 'idx_pr_product_id');
            $table->index('user_id', 'idx_pr_user_id');

            // Foreign keys dengan nama eksplisit
            $table->foreign('product_id', 'fk_pr_product')
                  ->references('id')->on('products')
                  ->onDelete('cascade');

            $table->foreign('user_id', 'fk_pr_user')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Pastikan drop FK dulu pakai nama yang sama
        Schema::table('product_reviews', function (Blueprint $table) {
            // pakai try-catch di DB level jika perlu, tapi biasanya aman:
            $table->dropForeign('fk_pr_product');
            $table->dropForeign('fk_pr_user');
            $table->dropIndex('idx_pr_product_id');
            $table->dropIndex('idx_pr_user_id');
        });

        Schema::dropIfExists('product_reviews');
    }
};
