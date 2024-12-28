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
        Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->Integer('order_increment_id')->unique(); 
                $table->Integer('user_id'); 
                $table->string('name'); 
                $table->string('email'); 
                $table->string('phone'); 
                $table->text('address'); 
                $table->text('address_2')->nullable(); 
                $table->string('city'); 
                $table->string('state'); 
                $table->string('country');
                $table->string('pincode'); 
                $table->string('coupon')->nullable(); 
                $table->decimal('coupon_discount', 8, 2)->default(0); 
                $table->decimal('total', 8, 2); 
                $table->string('payment_method'); 
                $table->string('shipping_method');
                $table->string('shipping_cost');
                $table->string('sub_total');
                $table->timestamps(); 
        });
    }




    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
