<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    protected $guarded = [];

    public function priest()
    {
        return $this->belongsTo(Priest::class);
    }

    public function priestHistory()
    {
        return $this->hasMany(ParishPriestHistory::class);
    }
}