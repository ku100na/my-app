<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelRecord extends Model
{
    protected $fillable = [
        'travel_plan_id',
        'review',
        'cost',
    ];

    public function travelPlan() {
        return $this->belongsTo(TravelPlan::class);
    }
}
