<?php

namespace App\Models\Api\V1;
use App\Enums\SpecializationEnum;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'hospital_id'

    ];

    public function scheudle()
    {
        return $this->hasMany(Schedule::class);
    }

    public function leave(){
        return $this->hasMany(Leave::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    

}
