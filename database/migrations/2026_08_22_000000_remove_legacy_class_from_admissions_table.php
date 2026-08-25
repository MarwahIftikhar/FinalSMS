<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('admissions', 'class')) {
            Schema::table('admissions', function (Blueprint $table) {
                $table->dropColumn('class');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('admissions', 'class')) {
            Schema::table('admissions', function (Blueprint $table) {
                $table->string('class')->nullable();
            });
        }
    }
};
