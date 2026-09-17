<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change temprature column from varchar to decimal(5,2)
        DB::statement("ALTER TABLE `patient_clinical_records` MODIFY COLUMN `temprature` DECIMAL(5,2) NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `patient_clinical_records` MODIFY COLUMN `temprature` VARCHAR(255) NULL;");
    }
};
