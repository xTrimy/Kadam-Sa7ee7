<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function redirect($id)
    {
        $notification = Auth::user()->notifications->find($id);
        if ($notification->notifiable_id != auth()->user()->id) {
            return abort(403);
        }
        $notification->read_at = now();
        $notification->save();
        if (isset($notification->data['link'])) {
            return redirect($notification->data['link'])->with('success', $notification->data['message']);
        }else{
            return redirect()->back();
        }
    }

    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return view('notifications.view', compact('notifications'));
    }
}
