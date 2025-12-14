<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParishPriestHistory extends Model
{
    protected $table = 'parish_priest_history';

    protected $fillable = [
        'parish_id',
        'priest_id',
        'assigned_from',
        'assigned_to',
    ];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    public function priest()
    {
        return $this->belongsTo(Priest::class);
    }
}

