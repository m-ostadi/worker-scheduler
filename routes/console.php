<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Silber\Bouncer\Database\Ability;
use Symfony\Component\Process\Exception\ProcessFailedException;

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

        Bouncer::allow('admin')->to(['schedules-approval','view-users', 'create-users', 'edit-users', 'delete-users', 'roles']);

    });
})->purpose('generate permissions');
Artisan::command('easy:install', function () {
    $total_steps = 3;
    Artisan::call('migrate:fresh');
    $this->comment("1/$total_steps tables created");

    Artisan::call("db:seed");
    $this->comment("2/$total_steps sample data imported");

    Artisan::call("permissions:generate");
    $this->comment("3/$total_steps permissions list imported");

    $this->comment("npm install ...");
    $output = run_command(['npm', 'install']);
    $this->comment($output);
    $this->comment("4/$total_steps npm packages installed successfully");

    $this->comment("npm run dev ...");
    $output = run_command(['npm', 'run', 'dev']);
    $this->comment($output);
    $this->comment("5/$total_steps npm run finished successfully");



})->purpose('generate permissions');

function run_command($command){
    $process = new \Symfony\Component\Process\Process($command);
    $process->run();
    // executes after the command finishes
    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }

    return $process->getOutput();
}
