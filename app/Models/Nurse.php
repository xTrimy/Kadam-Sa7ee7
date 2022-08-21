<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'hospital_id',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
