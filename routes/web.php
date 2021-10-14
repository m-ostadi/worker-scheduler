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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();
    $jobs = \App\Models\Job::all();

    return Inertia::render('Dashboard',compact('user','jobs'));
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['as'=>'admin.','prefix' => 'admin'], function () {

        Route::get('/schedule-requests',function (){
            $user = auth()->user();
            $schedules = \App\Models\Schedule::with('worker')->get()
                ->mapToGroups(function (\App\Models\Schedule $item,$key){
                    return [$item->job_id =>  $item];
                })->map(function ($job_scs){
                    return $job_scs->mapToGroups(function (\App\Models\Schedule $item,$key){
                        return [$item->started_at->dayOfWeek =>  $item];
                    })->sortKeys();
                });

            $jobs = \App\Models\Job::get();

//            foreach ($jobs as $key => $job){
//                $jobs[$key]->schedules = $job->schedules->mapToGroups(function (\App\Models\Schedule $item,$key){
//                    return [$item->started_at->dayOfWeek => $item];
//                })->sortKeys();
//            }
            return Inertia::render('Admin/ScheduleRequests',[
                'user'=>$user,
                'schedules'=>$schedules,
                'jobs'=>$jobs
            ]);
        })->name('schedules');
        Route::post('/schedule-requests/approve',function (\Illuminate\Http\Request $request){
            $user = auth()->user();
            $input = $request->validate(['id'=>'required|integer|exists:schedules']);
            $schedule = \App\Models\Schedule::find($input['id']);
            $schedule->verified = 1;
            $schedule->verified_at = now();
            $schedule->admin_id = $user->id;
            $schedule->save();
            return Redirect::route('admin.schedules');
        })->name('schedules.approve');
        Route::post('/schedule-requests/decline',function (\Illuminate\Http\Request $request){
            $user = auth()->user();
            $input = $request->validate(['id'=>'required|integer|exists:schedules']);
            $schedule = \App\Models\Schedule::find($input['id']);
            $schedule->verified = 0;
            $schedule->verified_at = now();
            $schedule->admin_id = $user->id;
            $schedule->save();
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


