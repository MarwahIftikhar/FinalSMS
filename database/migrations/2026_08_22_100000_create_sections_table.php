<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        foreach (['A', 'B', 'C', 'D', 'E'] as $name) {
            DB::table('sections')->insert([
                'name' => $name,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('admissions', function (Blueprint $table) {
            $table->foreignId('section_id')
                ->nullable()
                ->constrained('sections')
                ->nullOnDelete();
        });

        DB::table('admissions')->whereNotNull('section')->orderBy('id')->each(function ($admission) {
            $sectionId = DB::table('sections')
                ->where('name', trim($admission->section))
                ->value('id');

            if ($sectionId) {
                DB::table('admissions')
                    ->where('id', $admission->id)
                    ->update(['section_id' => $sectionId]);
            }
        });

        Schema::table('admissions', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }

    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->string('section')->nullable();
        });

        DB::table('admissions')->whereNotNull('section_id')->orderBy('id')->each(function ($admission) {
            $name = DB::table('sections')->where('id', $admission->section_id)->value('name');

            DB::table('admissions')->where('id', $admission->id)->update(['section' => $name]);
        });

        Schema::table('admissions', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });

        Schema::dropIfExists('sections');
    }
};
