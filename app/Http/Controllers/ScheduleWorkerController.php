<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class ScheduleWorkerController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $jobs = Job::all();
        if(!$user->isA('admin'))
            $schedules = Schedule::calendarDate($user->id);
        else
            $schedules = Schedule::calendarDate();
        $week = getWeek();

        return Inertia::render('Dashboard',compact('user','jobs','schedules','week'));
    }
    public function store(Request $request){
        $input = $request->validate([
            'started_at'=>'required|date',
            'ended_at'=>'required|date',
            'job_id'=>'integer|required|exists:jobs,id'
        ]);
        $input['worker_id'] = auth()->id();
        Schedule::create($input);
        session()->flash('message','Schedule request submitted for admin approval.');
        return Redirect::route('dashboard');
    }
}
