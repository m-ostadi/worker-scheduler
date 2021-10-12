<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->dateTime('started_at')->index()->nullable();
            $table->dateTime('ended_at')->nullable();
            //$table->date('day')->index();
            //$table->enum('weekday',['sun','mon','tue','wed','thr','fri','sat'])->nullable();
            //$table->enum('shift',['morning','evening','night'])->nullable();
            $table->foreignId('worker_id');
            $table->foreignId('job_id')->nullable();
            $table->foreignId('admin_id')->nullable()->index();
            $table->dateTime('verified_at')->nullable();
            $table->boolean('verified')->nullable();
            $table->string('status',20)->nullable()->index()->comment("'not_started','working','done'");
            $table->text('description')->nullable();
            $table->index(['worker_id','job_id','verified']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
