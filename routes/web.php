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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum'],'as'=>'admin.'], function () {

    Route::group(['as'=>'admin.','prefix' => 'admin'], function () {
        Route::get('/schedule-requests',function (){
            $user = auth()->user();
            $schedules = \App\Models\Schedule::whereNull('verified')->get();
            return Inertia::render('',[]);
        })->name('schedules');
    });

    Route::group(['as'=>'worker.'], function () {
        Route::get('/schedules',function (){

        })->name('schedules');
    });

});


