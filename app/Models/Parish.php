<?php

namespace App\Models;

use App\Models\Tithe;
use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    protected $guarded = [];

    public function communities()
    {
        return $this->hasMany(SmallCommunity::class);
    }

    public function priestHistory()
    {
        return $this->hasMany(ParishPriestHistory::class);
    }

    public function priests()
    {
        return $this->belongsToMany(Priest::class, 'parish_priest_history')
            ->withPivot(['assigned_from', 'assigned_to'])
            ->withTimestamps();
    }

    public function activePriests()
    {
        return $this->belongsToMany(Priest::class, 'parish_priest_history')
            ->wherePivotNull('assigned_to')
            ->withPivot(['assigned_from'])
            ->withTimestamps();
    }

    public function tithes()
    {
        return $this->hasMany(Tithe::class);
    }

    public function getTithesSumAmountAttribute()
    {
        return $this->tithes()->sum('amount');
    }

}