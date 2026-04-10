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

    public function getDurationTextAttribute()
    {
        $hours = intdiv($this->duration, 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}時間{$minutes}分";
        }
        if ($hours > 0) {
            return "{$hours}時間";
        }
            return "{$minutes}分";
    }
}
