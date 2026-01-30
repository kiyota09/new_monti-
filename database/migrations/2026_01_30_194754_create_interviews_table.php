<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            $table->date('interview_date');
            $table->time('interview_time');
            $table->string('interview_type'); // phone, video, in_person
            $table->text('interviewers')->nullable(); // Comma-separated names
            $table->text('notes')->nullable();
            $table->decimal('score', 3, 1)->nullable(); // 0-10 scale
            $table->text('feedback')->nullable();
            $table->foreignId('scheduled_by')->constrained('users');
            $table->timestamp('scheduled_at');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['interview_date', 'interview_time']);
            $table->index(['applicant_id', 'interview_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};