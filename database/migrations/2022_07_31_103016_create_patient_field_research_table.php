<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientFieldResearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_field_research', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('governorate_id')->constrained();
            $table->boolean('gender');
            $table->string('center');
            $table->string('village');
            $table->string('address');
            $table->string('phone');
            $table->string('national_id');
            $table->integer('age');
            $table->foreignId('marital_status_id')->constrained();
            $table->integer('individuals');
            $table->foreignId('educational_level_id')->constrained();
            $table->string('job');
            $table->string('sector_type');
            $table->string('work_type');
            $table->boolean('personal_project');
            $table->string('project_type');
            $table->string('income_source');
            $table->boolean('is_family_member_has_diabetes');
            $table->string('family_member_with_diabetes')->nullable();
            $table->string('period_of_diabetes');
            $table->string('period_of_diabetic_foot');
            $table->string('symptoms');
            $table->string('medications');
            $table->string('other_chronic_diseases');
            $table->string('visiting_hospital');
            $table->string('costs_of_treatment');
            $table->date('last_visit_date');
            $table->string('heared_about_initiative');
            $table->string('heared_about_organization');
            $table->boolean('benefited_from_organization');
            $table->string('benefits_from_organization');
            $table->integer('rating');
            $table->boolean('evaluation');
            $table->text('evaluation_comment')->nullable();
            $table->string('home_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_field_research');
    }
}
