<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $hospitals = Hospital::with('patients')->get();
        // count all patients for each hospital for every day
        $patients_count = [];
        foreach($hospitals as $hospital){
            $patients = $hospital->patients->groupBy(function($item){
                return $item->created_at->format('Y-m-d');
            })->map(function($item){
                return $item->count();
            });
            $patients_count[$hospital->name] = [];
            $patients_count[$hospital->name]['patients_count'] = $hospital->patients->count();
            $patients_count[$hospital->name]['patients_count_per_day'] = $patients;
        }

        // extract all days from $patients_count
        $days = [];
        foreach($patients_count as $hospital_name => $hospital_data){
            foreach($hospital_data['patients_count_per_day'] as $day => $count){
                if(!in_array($day, $days)){
                    $days[] = $day;
                }
            }
        }
        return view('dashboard', compact('hospitals', 'patients_count', 'days'));


    }
}
