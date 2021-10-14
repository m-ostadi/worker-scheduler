<?php

use App\Http\Controllers\ScheduleAdminController;
use App\Http\Controllers\ScheduleWorkerController;
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
   \App\Models\Schedule::create([
       'started_at' => now(),
       'ended_at'=> now()->addHours(4),
       'worker_id' => 3,
       'job_id' => 1,
   ])->load(['worker','job']);

//    event(new \App\Events\MessageEvent('salam'));

});
Route::get('/welcome', function () {
    return view('welcome');
});



Route::middleware(['auth:sanctum'])->get('/dashboard',[ScheduleWorkerController::class,'index'] )->name('dashboard');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['as'=>'admin.','prefix' => 'admin'], function () {
        Route::get('/schedule-requests',[ScheduleAdminController::class,'index'])->name('schedules');
        Route::post('/schedule-requests/approve',[ScheduleAdminController::class,'approve'])->name('schedules.approve');
        Route::post('/schedule-requests/decline',[ScheduleAdminController::class,'decline'])->name('schedules.decline');
    });

    Route::group(['as'=>'worker.'], function () {
        Route::post('/schedules',[ScheduleWorkerController::class,'store'])->name('schedules.store');
    });
});


