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
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('patient_clinical_records', 'record_date')) {
                $table->date('record_date')->nullable()->after('patient_id')->index();
            }
        });

        // Backfill existing clinical records with their created_at date
        DB::statement("UPDATE patient_clinical_records SET record_date = DATE(created_at) WHERE record_date IS NULL AND created_at IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            if (Schema::hasColumn('patient_clinical_records', 'record_date')) {
                $table->dropIndex(['record_date']);
                $table->dropColumn('record_date');
            }
        });
    }
};
