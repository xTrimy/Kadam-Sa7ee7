<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatuses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $martial_statuses = [
            "أعزب",
            "متزوج",
            "مطلق",
            "منفصل",
            "أرمل",
        ];
        foreach ($martial_statuses as $martial_status) {
            DB::table('marital_statuses')->insert([
                'name' => $martial_status
            ]);
        }
    }
}
