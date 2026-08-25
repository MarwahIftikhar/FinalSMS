<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('location');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('branches')->insert([
            'id' => 1,
            'name' => 'Main Branch',
            'location' => 'Main Location',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('admissions', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
        });

        Schema::dropIfExists('branches');
    }
};
