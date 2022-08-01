<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
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
}
