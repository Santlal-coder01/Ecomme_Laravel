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
            $table->string('name'); 
            $table->enum('status', ['1', '2'])->default('1'); 
            $table->boolean('is_featured')->default(0); 
            $table->string('sku');
            $table->integer('qty'); 
            $table->enum('stock_status', ['1', '0'])->default('1'); 
            $table->decimal('weight', 8, 2);
            $table->decimal('price', 8, 2); 
            $table->decimal('special_price', 8, 2); 
            $table->date('special_price_from'); 
            $table->date('special_price_to');  
            $table->text('short_description'); 
            $table->text('description'); 
            $table->string('related_product'); 
            $table->string('url_key'); 
            $table->string('meta_tag'); 
            $table->string('meta_title'); 
            $table->text('meta_description'); 
            $table->timestamps(); 
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
