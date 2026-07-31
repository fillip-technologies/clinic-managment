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
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            $table->string('diabetes')->default('Normal');
            $table->string('hypertension')->default('Normal');
            $table->string('obesity')->default('Normal');
            $table->string('infection')->default('Normal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            //
        });
    }
};
