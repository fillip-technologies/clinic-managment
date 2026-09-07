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
            if (!Schema::hasColumn('appoinments', 'father_name')) {
                $table->string('father_name', 255)->nullable()->after('patient_name');
            }
            if (!Schema::hasColumn('appoinments', 'address')) {
                $table->text('address')->nullable()->after('mail');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appoinments', function (Blueprint $table) {
            if (Schema::hasColumn('appoinments', 'father_name')) {
                $table->dropColumn('father_name');
            }
            if (Schema::hasColumn('appoinments', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
