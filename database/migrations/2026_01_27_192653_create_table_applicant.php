<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            // Name
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            // Birthdate
            $table->date('birth_date');

            // Address
            $table->string('street_address');
            $table->string('street_address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');

            // Contact
            $table->string('email');
            $table->string('phone');
            $table->string('linkedin')->nullable();

            // Position
            $table->string('position_applied');
            $table->string('source');
            $table->date('available_start_date');
            
            // Government Documents (NEW)
            $table->string('sss_document')->nullable();
            $table->string('philhealth_document')->nullable();
            $table->string('pagibig_document')->nullable();

            // Additional
            $table->string('expected_salary')->nullable();
            $table->string('notice_period')->nullable();
            $table->boolean('experience')->nullable();

            // Application Status
            $table->enum('status', [
                'pending', 
                'reviewed', 
                'interview_scheduled', 
                'interviewed',
                'shortlisted',
                'rejected',
                'hired'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};