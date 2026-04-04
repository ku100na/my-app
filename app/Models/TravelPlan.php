<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPlan extends Model
{
    protected $fillable = [
    'user_id',
    'title',
    'country',
    'city',
    'start_date',
    'end_date',
    'overview',
    'is_public',
    'photo_url',
    'status',
    ];
}
