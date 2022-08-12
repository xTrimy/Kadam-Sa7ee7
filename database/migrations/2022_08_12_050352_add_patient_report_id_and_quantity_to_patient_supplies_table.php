<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPatientReportIdAndQuantityToPatientSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_supplies', function (Blueprint $table) {
            $table->foreignId('patient_record_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_supplies', function (Blueprint $table) {
            $table->dropForeign(['patient_record_id']);
            $table->dropColumn('patient_record_id');
            $table->dropColumn('quantity');
        });
    }
}
