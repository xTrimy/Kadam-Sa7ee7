<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPatientReportIdToSupplyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_transactions', function (Blueprint $table) {
            $table->foreignId('patient_record_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supply_transactions', function (Blueprint $table) {
            $table->dropForeign(['patient_record_id']);
            $table->dropColumn('patient_record_id');
        });
    }
}
