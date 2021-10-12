<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Silber\Bouncer\Database\Ability;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('permissions:generate', function () {
    DB::transaction(function (){
        //$scope = 103;
        Ability::firstOrCreate(['name'=>'schedules-approval'],[ 'title'=>'schedules approval']);
        Ability::firstOrCreate(['name'=>'view-users'],[ 'title'=>'view users']);
        Ability::firstOrCreate(['name'=>'create-users'],[ 'title'=>'create users']);
        Ability::firstOrCreate(['name'=>'edit-users'],[ 'title'=>'edit users']);
        Ability::firstOrCreate(['name'=>'delete-users'],[ 'title'=>'delete users']);
        Ability::firstOrCreate(['name'=>'roles'],[ 'title'=>'edit roles']);

    });
})->purpose('generate permissions');
