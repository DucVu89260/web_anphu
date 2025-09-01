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
        Schema::create('facebook_posts', function (Blueprint $table) {
            $table->id();
            $table->string('fb_post_id')->unique(); // ID post trên Facebook
            $table->longText('message')->nullable(); // nội dung bài post
            $table->text('permalink_url')->nullable(); // link đến post
            $table->text('full_picture')->nullable(); // ảnh đại diện post
            $table->text('video_source')->nullable(); // link video nếu có
            $table->string('name')->nullable();
            $table->string('caption')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('posted_at')->nullable();

            $table->string('related_type')->nullable();
            $table->string('related_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_posts');
    }
};
