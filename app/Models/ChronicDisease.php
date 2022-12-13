<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ChronicDisease extends Model
{
    use HasFactory, LogsActivity;
    protected $hidden = ['pivot'];

}
