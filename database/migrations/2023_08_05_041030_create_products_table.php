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
            $table->bigInteger('category_id')->references('id')->on('categories');
            $table->string('slug')->unique();
            $table->string('name', 255)->comment('product_name')->nullable();
            $table->integer('price')->comment('product_price')->nullable();
            $table->integer('quantity')->comment('product_quantity')->nullable();
            $table->integer('main_image')->comment('product_image')->nullable();
            $table->longText('description')->comment('product_description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('product_status')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
