<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // belongs to a parish
            $table->foreignId('parish_id')->constrained()->cascadeOnDelete();

            // belongs to a small community
            $table->foreignId('small_community_id')
                ->nullable()
                ->constrained('small_communities')
                ->nullOnDelete();

            // basic info
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();

            // contacts
            $table->string('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();

            // sacraments
            $table->boolean('is_baptised')->default(false);
            $table->string('baptism_certificate_no')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
