<?php

namespace App\Models\Api\V1;


use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable =[
        "doctor_id",
        "hospital_id",
        "start_date",
        "end_date",
        "start_time",
        "end_time"
    ];

   

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
   
}
