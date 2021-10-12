<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Job::firstOrCreate(['title' => 'Barista']);
        Job::firstOrCreate(['title' => 'Security']);
        Job::firstOrCreate(['title' => 'Waiter']);

        \App\Models\User::factory(10)->create()->each(function (User $user){
            $user->assign('worker');
        });

        Schedule::factory(10)->create();
    }
}
