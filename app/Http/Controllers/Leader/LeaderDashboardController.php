<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\SmallCommunityLeader;

class LeaderDashboardController extends Controller
{
    public function index()
    {
        $leaderScc = SmallCommunityLeader::getLeaderScc(auth()->id());
        $scc = $leaderScc?->community;
        $membersCount = Member::where('small_community_id', $scc?->id)->count();
        $recentMembers = Member::where('small_community_id', $scc?->id)
            ->whereMonth('created_at', now()->month)
            ->get();

        $positions = $scc?->leaders()->with('member', 'position')->get();
        return view('leader.dashboard', compact(
            'scc',
            'membersCount',
            'recentMembers',
            'positions'
        ));
    }
}