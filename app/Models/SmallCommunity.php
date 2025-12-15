<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmallCommunity extends Model
{
    protected $guarded = [];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    public function leader()
    {
        return $this->hasOne(SmallCommunityLeader::class)->where('is_active', true);
    }

    public function leaders()
    {
        return $this->hasMany(SmallCommunityLeader::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'small_community_id');
    }

    public function leaderHistory()
    {
        return $this->hasMany(SmallCommunityLeader::class);
    }

    public function currentLeader()
    {
        return $this->hasOne(SmallCommunityLeader::class)->where('is_active', true);
    }

}