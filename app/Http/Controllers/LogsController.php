<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index()
    {
        $logs = \Spatie\Activitylog\Models\Activity::paginate(50);
        return view('settings.log.log', compact('logs'));
    }
}
