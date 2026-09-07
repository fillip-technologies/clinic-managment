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
        if (Schema::hasTable('appoinments')) {
            Schema::rename('appoinments', 'on_site_appointment');
        } elseif (Schema::hasTable('appointments')) {
            Schema::rename('appointments', 'on_site_appointment');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('on_site_appointment')) {
            Schema::rename('on_site_appointment', 'appoinments');
        }
    }
};
