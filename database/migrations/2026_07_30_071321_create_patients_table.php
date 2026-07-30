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
       Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name', 255);
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('record_date')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('rcdho_grade', 50)->nullable();
            $table->string('new_registration_no', 50)->unique();
            $table->string('father_husband_name', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index('patient_name');
            $table->index('record_date');
            $table->index('mobile_no');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
