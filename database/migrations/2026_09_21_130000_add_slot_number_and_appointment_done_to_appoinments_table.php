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
            if (!Schema::hasColumn('appoinments', 'slot_number')) {
                $table->string('slot_number', 20)->nullable()->after('appointment_scheduled_date');
            }
            if (!Schema::hasColumn('appoinments', 'appointment_done')) {
                $table->boolean('appointment_done')->default(false)->after('slot_number');
            }
            $table->index(['appointment_scheduled_date', 'slot_number'], 'idx_app_sched_date_slot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appoinments', function (Blueprint $table) {
            $table->dropIndex('idx_app_sched_date_slot');
            if (Schema::hasColumn('appoinments', 'appointment_done')) {
                $table->dropColumn('appointment_done');
            }
            if (Schema::hasColumn('appoinments', 'slot_number')) {
                $table->dropColumn('slot_number');
            }
        });
    }
};
