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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_email')->nullable();

            $table->string('company_phone_1')->nullable();
            $table->string('company_phone_2')->nullable();
    
            $table->text('company_address_1')->nullable();
            $table->text('company_address_2')->nullable();

            $table->text('policy')->nullable();
            
            $table->json('social_links')->nullable();
            $table->text('working_hours')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
