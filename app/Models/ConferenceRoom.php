<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceRoom extends Model
{
    use HasFactory;

    const CR_ROOMS = [
        'HARBOUR'=>1,
        'DEHRADUN'=>2,
        'NEST'=>3,
        'LANDOUR'=>4,
        'PHILLIE'=>5
    ];
}
