<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPatientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_records', function (Blueprint $table) {
            $table->date('operation_date')->nullable();
            $table->boolean('is_checked')->default(false);
            $table->foreignId('checked_by')->nullable()->constrained('users')->onDelete('set null')->onUpdate('set null');
            $table->boolean('supplied')->default(false);
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
            $table->dropColumn('operation_date');
            $table->dropColumn('is_checked');
            $table->dropColumn('checked_by');
            $table->dropColumn('supplied');
        });
    }
}
