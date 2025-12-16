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

    public function priest()
    {
        return $this->belongsTo(Priest::class, 'priest_id');
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