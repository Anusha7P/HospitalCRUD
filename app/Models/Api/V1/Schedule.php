<?php

namespace App\Models\Api\V1;

use App\ScheduleEnum;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable =[
        "doctor_id",
        "day",
        "start_time",
        "end_time"
    ];

    protected $casts = [
        'day' => ScheduleEnum::class, 
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
   
}
