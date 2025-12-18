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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('unit')->default('pcs'); // pcs, kg, ltr, etc.
            $table->decimal('cost_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('minimum_price', 15, 2)->nullable();
            $table->boolean('track_inventory')->default(true);
            $table->integer('reorder_level')->default(0);
            $table->integer('reorder_quantity')->default(0);
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
