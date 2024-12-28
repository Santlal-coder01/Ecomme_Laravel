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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();  
            $table->string('parent_category')->nullable(); 
            $table->string('name');  
            $table->boolean('status')->default(1); 
            $table->boolean('show_in_menu')->default(0);  
            $table->string('url_key')->unique(); 
            $table->string('meta_tag')->nullable();  
            $table->string('meta_title')->nullable();  
            $table->text('meta_description')->nullable();     
            $table->text('short_description')->nullable();              
            $table->text('description')->nullable();             
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
