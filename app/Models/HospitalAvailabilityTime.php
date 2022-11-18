<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalAvailabilityTime extends Model
{
    use HasFactory;
    protected $fillable = [
        "day",
        "start_time",
        "end_time",
        "hospital_id"
    ];
}
