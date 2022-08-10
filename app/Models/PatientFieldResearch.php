<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFieldResearch extends Model
{
    use HasFactory;

    public function governorate(){
        return $this->belongsTo(Governorate::class);
    }
    public function marital_status(){
        return $this->belongsTo(MaritalStatus::class);
    }
    public function educational_level(){
        return $this->belongsTo(EducationalLevel::class);
    }
}
