<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contact',
        'type',
        'services'
    ];
}
