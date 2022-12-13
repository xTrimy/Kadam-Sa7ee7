<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Patient extends Model
{
    use HasFactory, LogsActivity;
    public function chronic_diseases()
    {
        return $this->belongsToMany(ChronicDisease::class, 'patient_chronic_disease')->select('name');
    }

    public function records()
    {
        return $this->hasMany(PatientRecord::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function field_research()
    {
        return $this->hasMany(PatientFieldResearch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function supplies(){
        return $this->hasMany(PatientSupply::class);
    }

    public function patient_records(){
        return $this->hasMany(PatientRecord::class);
    }

    public function getAge(){
        $diff = abs(strtotime(date('Y-m-d')) - strtotime($this->birth_date));
        $age = floor($diff / (365 * 60 * 60 * 24));

        return $age;
    }

    public function displayChronicDiseases(){
        return implode(', ',array_map(function($value){
                                return $value["name"];
                            },$this->chronic_diseases->toArray()));
    }
}
