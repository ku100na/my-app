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

    public function travelRecord() {
        return $this->hasOne(TravelRecord::class);
    }

    public function days() {
        return $this->hasMany(Day::class);
    }

    public function favoritedUsers() {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
