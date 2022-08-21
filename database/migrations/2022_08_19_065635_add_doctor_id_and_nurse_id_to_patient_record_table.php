<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoctorIdAndNurseIdToPatientRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_records', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('nurse_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_records', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['nurse_id']);
            $table->dropColumn('doctor_id');
            $table->dropColumn('nurse_id');
        });
    }
}
