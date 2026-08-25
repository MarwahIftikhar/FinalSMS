<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admissions', function (Blueprint $table) {

            // Store the ID of the class instead of storing
            // the class name directly in admissions.
            $table->foreignId('class_id')
                ->nullable()
                ->constrained('classes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {

            // Remove the foreign key first.
            $table->dropForeign(['class_id']);

            // Then remove the column.
            $table->dropColumn('class_id');
        });
    }
};