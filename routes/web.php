<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/test', function () {
//   $s = \App\Models\Schedule::create([
//       'started_at' => now(),
//       'ended_at'=> now()->addHours(4),
//       'worker_id' => 3,
//       'job_id' => 1,
//   ]);

    event(new \App\Events\MessageEvent('salam'));

});
Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();
    $jobs = \App\Models\Job::all();
    if(!$user->isA('admin'))
        $schedules = \App\Models\Schedule::calendarData($user->id);
    else
        $schedules = \App\Models\Schedule::calendarData();

    return Inertia::render('Dashboard',compact('user','jobs','schedules'));
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['as'=>'admin.','prefix' => 'admin'], function () {

        Route::get('/schedule-requests',function (){
            $user = auth()->user();
            $schedules = \App\Models\Schedule::calendarData();
            $jobs = \App\Models\Job::get();

            return Inertia::render('Admin/ScheduleRequests',compact('user','schedules','jobs'));
        })->name('schedules');

        Route::post('/schedule-requests/approve',function (\Illuminate\Http\Request $request){
            $user = auth()->user();
            $input = $request->validate(['id'=>'required|integer|exists:schedules']);
            $schedule = \App\Models\Schedule::find($input['id']);
            $schedule->update(['verified' => 1,'verified_at' => now(),'admin_id' => $user->id]);;
            return Redirect::route('admin.schedules');
        })->name('schedules.approve');

        Route::post('/schedule-requests/decline',function (\Illuminate\Http\Request $request){
            $user = auth()->user();
            $input = $request->validate(['id'=>'required|integer|exists:schedules']);
            $schedule = \App\Models\Schedule::find($input['id']);
            $schedule->update(['verified' => 0,'verified_at' => now(),'admin_id' => $user->id]);;
            return Redirect::route('admin.schedules');
        })->name('schedules.decline');

    });

    Route::group(['as'=>'worker.'], function () {
        Route::post('/schedules',function (\Illuminate\Http\Request $request){
            $input = $request->validate([
                'started_at'=>'required|date',
                'ended_at'=>'required|date',
                'job_id'=>'integer|required|exists:jobs,id'
            ]);
            $input['worker_id'] = auth()->id();
            \App\Models\Schedule::create($input);
            session()->flash('message','Schedule request submitted for admin approval.');
            return Redirect::route('dashboard');
        })->name('schedules.store');
    });
});


