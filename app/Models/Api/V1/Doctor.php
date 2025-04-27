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


}
