<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'parish_id',
        'small_community_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'dob',
        'phone',
        'email',
        'is_baptised',
        'baptism_certificate_no',
    ];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    public function community()
    {
        return $this->belongsTo(SmallCommunity::class, 'small_community_id');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function sccLeaderships()
    {
        return $this->hasMany(SmallCommunityLeader::class);
    }

}
