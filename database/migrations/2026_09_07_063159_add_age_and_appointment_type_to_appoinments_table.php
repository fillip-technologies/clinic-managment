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
        Schema::table('appoinments', function (Blueprint $table) {
            if (!Schema::hasColumn('appoinments', 'age')) {
                $table->integer('age')->nullable()->after('patient_name');
            }
            if (!Schema::hasColumn('appoinments', 'appointment_type')) {
                $table->string('appointment_type', 50)->default('on_site')->after('patient_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appoinments', function (Blueprint $table) {
            if (Schema::hasColumn('appoinments', 'age')) {
                $table->dropColumn('age');
            }
            if (Schema::hasColumn('appoinments', 'appointment_type')) {
                $table->dropColumn('appointment_type');
            }
        });
    }
};
