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
        Schema::table('doctor_data', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_data', 'fullname')) {
                $table->string('fullname')->nullable();
            }
            if (!Schema::hasColumn('doctor_data', 'file')) {
                $table->json('file')->nullable();
            }
            if (!Schema::hasColumn('doctor_data', 'date')) {
                $table->string('date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_data', function (Blueprint $table) {
            //
        });
    }
};
