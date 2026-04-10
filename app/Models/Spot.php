<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'day_id',
        'name',
        'duration',
        'review',
    ];

    public function day() {
        return $this->belongsTo(Day::class);
    }
}
