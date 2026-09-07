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
            $table->string('c_peptide', 100)->nullable()->after('stop_insulin_date');
            $table->string('insulin_antibodies', 100)->nullable()->after('c_peptide');
            $table->string('mody_biomarkers', 150)->nullable()->after('insulin_antibodies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            $table->dropColumn(['c_peptide', 'insulin_antibodies', 'mody_biomarkers']);
        });
    }
};
