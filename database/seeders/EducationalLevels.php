<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationalLevels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educational_levels = [
            "لا يقرا",
            "يقرأ ويكتب",
            "ابتدائي",
            "اعدادي",
            "ثانوي/دبلوم",
            "فوق متوسط/معهد",
            "جامعي",
            "فوق جامعي"
        ];
        foreach($educational_levels as $educational_level) {
            DB::table('educational_levels')->insert([
                'name' => $educational_level
            ]);
        }
    }
}
