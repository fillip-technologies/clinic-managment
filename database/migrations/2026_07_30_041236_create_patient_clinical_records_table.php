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
        Schema::create('patient_clinical_records', function (Blueprint $table) {

            $table->id();
            $table->boolean('newly_detected')->default(false);
            $table->string('duration_of_diabetes', 100)->nullable();
            $table->date('start_insulin_date')->nullable();
            $table->date('stop_insulin_date')->nullable();
            $table->string('attachment', 255)->nullable();
            $table->decimal('height_cm', 5, 1)->nullable();
            $table->decimal('weight_kg', 5, 1)->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            $table->decimal('waist_height_ratio', 4, 2)->nullable();
            $table->string('bmi_group', 50)->nullable();
            $table->decimal('waist_cm', 5, 1)->nullable();
            $table->decimal('hip_cm', 5, 1)->nullable();
            $table->decimal('waist_hip_ratio', 4, 2)->nullable();
            $table->string('social_class', 50)->nullable();
            $table->string('income_class', 50)->nullable();
            $table->string('education', 100)->nullable();
            $table->string('physical_activity', 50)->nullable();
            $table->string('veg_nonveg', 50)->nullable();
            $table->boolean('htn')->default(false);
            $table->integer('sbp')->nullable()->comment('Systolic Blood Pressure (mmHg)');
            $table->integer('dbp')->nullable()->comment('Diastolic Blood Pressure (mmHg)');
            $table->decimal('hb_percent', 5, 2)->nullable()->comment('Hemoglobin %');
            $table->integer('plt')->nullable()->comment('Platelets');
            $table->decimal('mcv', 5, 1)->nullable()->comment('Mean Corpuscular Volume');
            $table->decimal('creatinine', 5, 2)->nullable()->comment('Creatinine (mg/dL)');
            $table->decimal('egfr', 5, 1)->nullable()->comment('eGFR (mL/min)');
            $table->decimal('acr', 5, 2)->nullable()->comment('Albumin-Creatinine Ratio');
            $table->decimal('uric_acid', 4, 2)->nullable()->comment('Uric acid (mg/dL)');
            $table->string('urine_cast_cell', 100)->nullable();
            $table->decimal('na_plus', 5, 1)->nullable()->comment('Sodium (mEq/L)');
            $table->decimal('k_plus', 4, 2)->nullable()->comment('Potassium (mEq/L)');
            $table->decimal('i_calcium', 4, 2)->nullable()->comment('Ionized Calcium (mg/dL)');
            $table->decimal('phosphorus', 4, 2)->nullable()->comment('Phosphorus (mg/dL)');
            $table->integer('sgpt')->nullable()->comment('SGPT (U/L)');
            $table->integer('sgot')->nullable()->comment('SGOT (U/L)');
            $table->integer('alkp')->nullable()->comment('ALKP (U/L)');
            $table->enum('hiv', ['Negative', 'Positive', 'Not Tested'])->default('Not Tested')->nullable();
            $table->enum('hbsag', ['Negative', 'Positive', 'Not Tested'])->default('Not Tested')->nullable();
            $table->enum('hcv', ['Negative', 'Positive', 'Not Tested'])->default('Not Tested')->nullable();
            $table->decimal('fib_score', 5, 2)->nullable();
            $table->string('fib_scan', 50)->nullable()->comment('FibroScan result (kPa)');
            $table->text('usg')->nullable()->comment('Ultrasound findings');
            $table->decimal('chol', 5, 1)->nullable()->comment('Total Cholesterol (mg/dL)');
            $table->decimal('tg', 5, 1)->nullable()->comment('Triglycerides (mg/dL)');
            $table->decimal('hdl', 4, 1)->nullable()->comment('HDL (mg/dL)');
            $table->decimal('ldl', 5, 1)->nullable()->comment('LDL (mg/dL)');
            $table->decimal('bsf', 5, 1)->nullable()->comment('Blood Sugar Fasting (mg/dL)');
            $table->decimal('bspp', 5, 1)->nullable()->comment('Blood Sugar Post Prandial (mg/dL)');
            $table->decimal('hba1c', 4, 1)->nullable()->comment('HbA1c (%)');
            $table->decimal('tsh', 5, 2)->nullable()->comment('TSH (µIU/mL)');
            $table->decimal('t3', 5, 1)->nullable()->comment('T3 (ng/dL)');
            $table->decimal('t4', 5, 1)->nullable()->comment('T4 (µg/dL)');
            $table->decimal('vitamin_d25', 5, 1)->nullable()->comment('Vitamin D25 (ng/mL)');
            $table->decimal('vitamin_b12', 6, 1)->nullable()->comment('Vitamin B12 (pg/mL)');
            $table->decimal('s_cortisol', 5, 1)->nullable()->comment('Serum Cortisol (µg/dL)');
            $table->string('dex_skip_test', 100)->nullable()->comment('Dexamethasone Suppression Test');
            $table->text('ophthalmic_ex')->nullable()->comment('Ophthalmic Examination');
            $table->text('foot_ev')->nullable()->comment('Foot Evaluation');
            $table->text('car_echo_ev')->nullable()->comment('Cardiac Echo Evaluation');
            $table->timestamps();
            $table->softDeletes();
            $table->index('patient_name');
            $table->index('record_date');
            $table->index('mobile_no');
            $table->index('bmi_group');
            $table->index(
                ['newly_detected', 'duration_of_diabetes'],
                'idx_new_diabetes'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_clinical_records');
    }
};
