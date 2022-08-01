<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('hospital_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->integer('quantity');
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
        Schema::dropIfExists('supply_transactions');
    }
}
