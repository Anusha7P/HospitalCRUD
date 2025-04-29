<?php

namespace App\Models\Api\V2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Doctor;
use App\Models\Api\V1\Patient;
use App\Models\Api\V1\Hospital;



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
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
