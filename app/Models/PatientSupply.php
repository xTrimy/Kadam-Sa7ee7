<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class PatientSupply extends Model
{
    use HasFactory, LogsActivity;

    public function supply(){
        return $this->belongsTo(Supply::class);
    }
}
