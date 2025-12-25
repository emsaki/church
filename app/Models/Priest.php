<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priest extends Model
{
    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parishHistory()
    {
        return $this->hasMany(ParishPriestHistory::class);
    }

    public function parishes()
    {
        return $this->belongsToMany(Parish::class, 'parish_priest_history')
            ->withPivot(['assigned_from', 'assigned_to'])
            ->withTimestamps();
    }

    public function activeParishes()
    {
        return $this->belongsToMany(Parish::class, 'parish_priest_history')
            ->wherePivotNull('assigned_to')
            ->withPivot(['assigned_from'])
            ->withTimestamps();
    }

}
