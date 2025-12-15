<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParishPriestHistory extends Model
{
    protected $table = 'parish_priest_history';

    protected $guarded = [];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    public function priest()
    {
        return $this->belongsTo(Priest::class);
    }
}

