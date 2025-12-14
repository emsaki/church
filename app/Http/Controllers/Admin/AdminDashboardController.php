<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Parish;
use App\Models\Priest;
use App\Models\SmallCommunity;
use App\Models\SmallCommunityLeader;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'priests' => Priest::count(),
            'parishes' => Parish::count(),
            'communities' => SmallCommunity::count(),
            'members' => Member::count(),
            'leaders' => SmallCommunityLeader::count(),
            'recentMembers' => Member::latest()->take(5)->get(),
        ]);
    }
}