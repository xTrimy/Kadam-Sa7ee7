<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class HospitalAvailabilityTime extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        "day",
        "start_time",
        "end_time",
        "hospital_id"
    ];
}
