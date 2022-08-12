<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'record_type',
        'record_date',
        'record_description',
        'is_checked',
        'supplied',
        'checked_by',
        'record_photo',
        'record_notes',
        'operation_date'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function supply_transactions(){
        return $this->hasMany(SupplyTransaction::class);
    }
    
}
