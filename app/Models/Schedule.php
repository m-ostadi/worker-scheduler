<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
