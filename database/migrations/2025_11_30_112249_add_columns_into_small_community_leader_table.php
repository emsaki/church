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
        Schema::table('small_community_leaders', function (Blueprint $table) {
            $table->date('assigned_from')->default(now());
            $table->date('assigned_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('small_community_leaders', function (Blueprint $table) {
            $table->dropColumn('assigned_from');
            $table->dropColumn('assigned_to');
        });
    }
};