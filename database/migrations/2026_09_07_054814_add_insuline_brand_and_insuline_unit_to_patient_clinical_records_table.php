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
            $table->string('insuline_brand', 100)->nullable()->after('duration_of_diabetes');
            $table->string('insuline_unit', 100)->nullable()->after('insuline_brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_clinical_records', function (Blueprint $table) {
            $table->dropColumn(['insuline_brand', 'insuline_unit']);
        });
    }
};
