<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        "doctor_id",
        "hospital_id",
        "leave_date"
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
