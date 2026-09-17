<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'dob')) {
                $table->date('dob')->nullable()->after('patient_name');
            }
        });

        // Approximate dob for existing records where age is present and dob is null
        if (Schema::hasColumn('patients', 'age')) {
            try {
                DB::statement("UPDATE patients SET dob = DATE_SUB(CURDATE(), INTERVAL age YEAR) WHERE age IS NOT NULL AND age > 0 AND dob IS NULL");
            } catch (\Throwable $e) {
                // In case DB engine doesn't support DATE_SUB, gracefully continue
            }

            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('age');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'age')) {
                $table->integer('age')->nullable()->after('patient_name');
            }
        });

        if (Schema::hasColumn('patients', 'dob')) {
            try {
                DB::statement("UPDATE patients SET age = TIMESTAMPDIFF(YEAR, dob, CURDATE()) WHERE dob IS NOT NULL AND age IS NULL");
            } catch (\Throwable $e) {
                // In case DB engine doesn't support TIMESTAMPDIFF, gracefully continue
            }

            Schema::table('patients', function (Blueprint $table) {
                $table->dropColumn('dob');
            });
        }
    }
};
