<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'started_at' => $a = now()->addHours(random_int(1,24*7)),
            'ended_at' => $a->addHours(random_int(1,4)),
            'worker_id' =>  User::whereIs('worker')->get()->random()->id,
            'job_id' => Job::all()->random()->id,
            'verified' => $v = random_int(0,1),
            'verified_at' => $v?now():null,

        ];
    }
}
