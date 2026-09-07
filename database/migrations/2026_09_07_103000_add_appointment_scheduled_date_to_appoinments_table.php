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
            if (!Schema::hasColumn('appoinments', 'appointment_scheduled_date')) {
                $table->date('appointment_scheduled_date')->nullable()->after('appointment_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appoinments', function (Blueprint $table) {
            if (Schema::hasColumn('appoinments', 'appointment_scheduled_date')) {
                $table->dropColumn('appointment_scheduled_date');
            }
        });
    }
};
