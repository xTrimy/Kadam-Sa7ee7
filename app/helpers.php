<?php

function extract_data_from_national_id($national_id){
    $governorates = ['01'=> 'Cairo',
                    '02'=> 'Alexandria',
                    '03'=> 'Port Said',
                    '04'=> 'Suez',
                    '11'=> 'Damietta',
                    '12'=> 'Dakahlia',
                    '13'=> 'Ash Sharqia',
                    '14'=> 'Qaliubiya',
                    '15'=> 'Kafr Al sheikh',
                    '16'=> 'Gharbiya',
                    '17'=> 'Monoufia',
                    '18'=> 'Beheira',
                    '19'=> 'Ismailia',
                    '21'=> 'Giza',
                    '22'=> 'Beni Suef',
                    '23'=> 'Fayoum',
                    '24'=> 'Minya',
                    '25'=> 'Assiut',
                    '26'=> 'Sohag',
                    '27'=> 'Qena',
                    '28'=> 'Aswan',
                    '29'=> 'Luxor',
                    '31'=> 'Red Sea',
                    '32'=> 'New Valley',
                    '33'=> 'Matrouh',
                    '34'=> 'North Sinai',
                    '35'=> 'South Sinai',
                    '88'=> 'Foreign'];
        // check if national id is valid
        // if not return false
        // if valid return array with data
        // national_id length is 14
        // first digit is birth century
        // the next 2 digits are birth year
        // the next 2 digits are birth month
        // the next 2 digits are birth day
        // the next 2 digits are birth governorate
        // then next 4 digits are serial number
        // the 13th digit is gender where even is female and odd is male
        // last digit is check digit
        
        if(strlen($national_id) != 14){
            return false;
        }
        $century = substr($national_id, 0, 1);
        $year = substr($national_id, 1, 2);
        $month = substr($national_id, 3, 2);
        $day = substr($national_id, 5, 2);
        $governorate = substr($national_id, 7, 2);
        $serial = substr($national_id, 9, 4);
        $gender = substr($national_id, 12, 1);
        $check_digit = substr($national_id, 13, 1);
        $birth_date = $year . '-' . $month . '-' . $day;
        // check if $governorate is valid
        if(!array_key_exists($governorate, $governorates)){
            return false;
        }
        $birth_governorate = $governorates[$governorate];
        $data = [
            'national_id' => $national_id,
            'century' => $century,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'governorate' => $governorate,
            'serial' => $serial,
            'gender'=> ($gender) % 2,
            'gender_word'=> ($gender) % 2 == 0 ? "Female":"Male",
            'check_digit' => $check_digit,
            'birth_date' => date('Y-m-d', strtotime($birth_date)),
            'birth_governorate' => $birth_governorate
        ];
        return $data;
}