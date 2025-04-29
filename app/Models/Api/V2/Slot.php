<?php

namespace App\Models\Api\V2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Schedule;
use App\Models\Api\V2\Appointment;

class Slot extends Model
{
    protected $fillable = [
        'schedule_id',
        'date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
