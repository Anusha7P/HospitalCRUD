<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'dob',
        'gender',
        'hospital_id'
    ];
}
