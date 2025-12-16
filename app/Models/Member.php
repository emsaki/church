<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [];
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

    public function tithes()
    {
        return $this->hasMany(Tithe::class, 'member_id');
    }

}
