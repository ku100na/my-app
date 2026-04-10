<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $fillable = [
        'travel_plan_id',
        'title',
        'day_number',
    ];

    public function travelPlan() {
        return $this->belongsTo(TravelPlan::class);
    }

    public function spots() {
        return $this->hasMany(Spot::class);
    }
}
