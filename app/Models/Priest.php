<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priest extends Model
{
    protected $guarded = [];

    public function parishes()
    {
        return $this->hasMany(Parish::class, 'priest_id');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parish()
    {
        return $this->hasOne(Parish::class, 'priest_id');
    }

}
