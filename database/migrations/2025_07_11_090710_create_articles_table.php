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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->requied();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('link')->nullable();   
            $table->text('description')->nullable();
            
            // $table->longText('content')->nullable();

            $table->unsignedBigInteger('category_id');

            $table->string('type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};