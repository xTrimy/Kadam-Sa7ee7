<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "address"
    ];

    public function patients(){
        return $this->hasMany(Patient::class);
    }

    public function supplies(){
        return $this->hasMany(HospitalSupply::class);
    }

    public function doctors(){
        return $this->hasMany(Doctor::class);
    }
    
    public function nurses(){
        return $this->hasMany(Nurse::class);
    }

    public function availability_times(){
        return $this->hasMany(HospitalAvailabilityTime::class);
    }
}
