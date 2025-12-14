<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmallCommunityLeader extends Model
{
    protected $fillable = [
        'small_community_id',
        'member_id',
        'position_id',
        'assigned_from',
        'assigned_to',
        'is_active',
    ];

    public function community()
    {
        return $this->belongsTo(SmallCommunity::class, 'small_community_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public static function leaderScc($userId)
    {
        return self::where('user_id', $userId)->value('small_community_id');
    }

    public static function getLeaderSccId($userId)
    {
        return self::where('userr_id', $userId)->value('small_community_id');
    }

    public static function getLeaderScc($userId)
    {
        return self::with('community.parish')->where('user_id', $userId)->first();
    }
}

