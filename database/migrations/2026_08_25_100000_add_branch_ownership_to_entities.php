<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['classes', 'sections', 'users'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('branch_id')->nullable()->after('id');
            });

            DB::table($tableName)->update(['branch_id' => 1]);

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('branch_id')->references('id')->on('branches')->restrictOnDelete();
            });
        }

        Schema::table('classes', function (Blueprint $table) {
            $table->dropUnique('classes_name_unique');
            $table->unique(['branch_id', 'name']);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropUnique('sections_name_unique');
            $table->unique(['branch_id', 'name']);
        });
    }

    public function down(): void
    {
        // Drop foreign keys first before dropping indexes
        foreach (['classes', 'sections', 'users'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
            });
        }

        // Then drop the composite unique indexes
        Schema::table('sections', function (Blueprint $table) {
            $table->dropUnique('sections_branch_id_name_unique');
            $table->unique('name');
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->dropUnique('classes_branch_id_name_unique');
            $table->unique('name');
        });

        // Finally drop the branch_id columns
        foreach (['classes', 'sections', 'users'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('branch_id');
            });
        }
    }
};
