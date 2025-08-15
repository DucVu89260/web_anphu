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
        Schema::table('consulting_requests', function (Blueprint $table) {
            $table->text('note')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('consulting_requests', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
};
