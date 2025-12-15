<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaptismRecord extends Model
{
    protected $guarded = [];

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