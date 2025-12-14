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
        Schema::create('baptism_records', function (Blueprint $table) {
            $table->id();

            // If person is an SCC-registered member
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();

            // Free-form details for babies / non-members
            $table->string('full_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();

            // Request submitted by SCC leader or admin
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();

            // Parish performing baptism
            $table->foreignId('parish_id')->nullable()->constrained()->nullOnDelete();

            // Priest completes these
            $table->string('certificate_number')->nullable();
            $table->date('baptism_date')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptism_records');
    }
};
