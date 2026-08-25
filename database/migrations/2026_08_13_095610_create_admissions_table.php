<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            // Branch
            $table->unsignedBigInteger('branch_id');

            // Student Information
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('nationality')->nullable();

            // Admission Information
            $table->string('admission_no')->unique();
            $table->date('admission_date');
            $table->string('section')->nullable();

            // Parent / Guardian Information
            $table->string('father_name');
            $table->string('mother_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone');
            $table->string('guardian_email')->nullable();

            // Address
            $table->text('address')->nullable();

            // Admission Status
            $table->string('status')->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};