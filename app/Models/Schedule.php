<?php

namespace App\Models;

use App\Events\ScheduleRequested;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property int $worker_id
 * @property int|null $job_id
 * @property int|null $admin_id
 * @property string|null $verified_at
 * @property int|null $verified
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \App\Models\Job|null $job
 * @property-read \App\Models\User $worker
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule verified()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWorkerId($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'started_at'=>'datetime',
        'ended_at'=>'datetime',
    ];
    protected $appends = ['weekday','start_hour','end_hour'];
    public function getWeekdayAttribute(){
        return $this->started_at->dayOfWeek;
    }
    public function getStartHourAttribute(){
        if($this->started_at)
            return $this->started_at->format('H:i');
        return null;
    }
    public function getEndHourAttribute(){
        if($this->ended_at)
            return $this->ended_at->format('H:i');
        return null;
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function worker(){
        return $this->belongsTo(User::class,'worker_id');
    }
    public function admin(){
        return $this->belongsTo(User::class,'admin_id');
    }
    public function scopeVerified($query){
        return $query->where('verified',1);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected static function booted()
    {
        static::created(function ($model){
            if($model->verified == null)
                event(new ScheduleRequested($model));
        });
    }

    static public function calendarData($user_id = null){

        return \App\Models\Schedule::when($user_id,function ($query)use($user_id){
            return $query->where('worker_id',$user_id);
        })->with('worker')->get()
            ->mapToGroups(function (\App\Models\Schedule $item,$key){
                return [$item->job_id =>  $item];
            })->map(function ($job_scs){
                return $job_scs->mapToGroups(function (\App\Models\Schedule $item,$key){
                    return [$item->started_at->dayOfWeek =>  $item];
                })->sortKeys();
            });
    }
}
