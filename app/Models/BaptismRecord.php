<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaptismRecord extends Model
{
    protected $fillable = [
        'member_id',
        'submitted_by',
        'parish_id',
        'certificate_number',
        'baptism_date',
        'status',
        'notes',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}