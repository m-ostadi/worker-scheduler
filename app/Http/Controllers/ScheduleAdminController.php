<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class ScheduleAdminController extends Controller
{
    public function index(){
        $user = auth()->user();
        $schedules = \App\Models\Schedule::calendarDate();
        $jobs = \App\Models\Job::get();
        $week = getWeek();
        return Inertia::render('Admin/ScheduleRequests',compact('user','schedules','jobs','week'));
    }
    public function approve(Request $request)
    {
        $user = auth()->user();
        $input = $request->validate(['id' => 'required|integer|exists:schedules']);
        $schedule = \App\Models\Schedule::find($input['id']);
        $schedule->update(['verified' => 1, 'verified_at' => now(), 'admin_id' => $user->id]);;
        return Redirect::route('admin.schedules');
    }
    public function decline(Request $request)
    {
        $user = auth()->user();
        $input = $request->validate(['id'=>'required|integer|exists:schedules']);
        $schedule = \App\Models\Schedule::find($input['id']);
        $schedule->update(['verified' => 0,'verified_at' => now(),'admin_id' => $user->id]);;
        return Redirect::route('admin.schedules');
    }
}
