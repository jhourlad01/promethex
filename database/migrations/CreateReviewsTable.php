<?php

namespace Database\Migrations;

use Framework\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating'); // 1-5 stars
            $table->string('title')->nullable(); // Review title
            $table->text('comment')->nullable(); // Review comment
            $table->boolean('is_verified_purchase')->default(false); // Verified purchase
            $table->boolean('is_approved')->default(true); // Admin approval
            $table->boolean('is_featured')->default(false); // Featured review
            $table->json('helpful_votes')->nullable(); // Store helpful votes as JSON
            $table->integer('helpful_count')->default(0); // Count of helpful votes
            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id', 'product_id']);
            $table->index(['rating', 'is_approved']);
            $table->index(['is_featured', 'is_approved']);
            
            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Unique constraint - one review per user per product
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->drop('reviews');
    }
}
