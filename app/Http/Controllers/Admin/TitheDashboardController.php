<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parish;
use App\Models\Tithe;
use Illuminate\Support\Facades\DB;

class TitheDashboardController extends Controller
{
    public function index()
    {
        // TOTAL COLLECTION
        $totalTithes = Tithe::sum('amount');

        // MONTHLY TREND (last 12 months)
        $monthlyTrend = Tithe::select(
                DB::raw("DATE_FORMAT(tithe_date, '%Y-%m') AS month"),
                DB::raw("SUM(amount) AS total")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->take(12)
            ->get();

        // PARISH COMPARISON
        $parishTotals = Parish::withSum('tithes', 'amount')->get();

        // TOP SCCs
        $topScc = DB::table('tithes')
            ->join('members', 'members.id', '=', 'tithes.member_id')
            ->join('small_communities', 'small_communities.id', '=', 'members.small_community_id')
            ->select(
                'small_communities.name',
                DB::raw("SUM(tithes.amount) AS total")
            )
            ->groupBy('small_communities.id', 'small_communities.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.tithes.dashboard', compact(
            'totalTithes',
            'monthlyTrend',
            'parishTotals',
            'topScc'
        ));
    }
}