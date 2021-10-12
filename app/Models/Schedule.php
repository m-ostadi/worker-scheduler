<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property string $started_at
 * @property string|null $ended_at
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

}
