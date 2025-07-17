<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable(); // Chỉ cho phép đánh giá khi đã mua
            $table->tinyInteger('rating')->unsigned(); // 1-5 sao
            $table->text('review')->nullable(); // Nội dung đánh giá
            $table->boolean('is_verified')->default(false); // Đã xác minh mua hàng
            $table->boolean('is_approved')->default(true); // Đã duyệt hiển thị
            $table->json('pros')->nullable(); // Ưu điểm (mảng)
            $table->json('cons')->nullable(); // Nhược điểm (mảng)
            $table->string('reviewer_name')->nullable(); // Tên người đánh giá
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');

            // Indexes
            $table->index(['product_id', 'rating']);
            $table->index(['user_id']);
            $table->index(['is_approved']);
            
            // Một user chỉ có thể đánh giá 1 lần cho 1 sản phẩm
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
