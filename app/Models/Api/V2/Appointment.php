<?php

namespace App\Models\Api\V2;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'hospital_name',
        'doctor_id',
        'patient_id',
        'slots_id',
        'status',
        'date_time',
        'notes'
    ];

    public function slot()
    {
        return $this->belongsTO(Slot::class);
    }
}
