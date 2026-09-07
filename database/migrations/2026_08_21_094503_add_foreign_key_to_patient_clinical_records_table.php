<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasForeignKey = false;
        try {
            $keys = \Illuminate\Support\Facades\DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.TABLE_CONSTRAINTS 
                WHERE CONSTRAINT_SCHEMA = DATABASE() 
                  AND TABLE_NAME = 'patient_clinical_records' 
                  AND CONSTRAINT_TYPE = 'FOREIGN KEY'
            ");
            foreach ($keys as $key) {
                if ($key->CONSTRAINT_NAME === 'patient_clinical_records_patient_id_foreign') {
                    $hasForeignKey = true;
                    break;
                }
            }
        } catch (\Throwable $e) {
            $hasForeignKey = false;
        }

        if (!$hasForeignKey) {
            Schema::table('patient_clinical_records', function (Blueprint $table) {
                // If the column already exists, add the foreign key constraint
                if (Schema::hasColumn('patient_clinical_records', 'patient_id')) {
                    $table->foreign('patient_id')
                        ->references('id')
                        ->on('patients')
                        ->cascadeOnDelete();
                } else {
                    // If column doesn't exist, create it with the foreign key
                    $table->foreignId('patient_id')
                        ->after('id')
                        ->constrained('patients')
                        ->cascadeOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
        });
    }
};
