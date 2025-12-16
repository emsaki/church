<?php

namespace App\Http\Controllers\Priest;

use App\Http\Controllers\Controller;
use App\Models\Parish;
use App\Models\SmallCommunity;
use App\Models\Tithe;

class TitheReportController extends Controller
{
    /**
     * Show summary of parishes under this priest
     */
    public function index()
    {
        $priest = auth()->user()->priest;
        if (!$priest) {
            abort(403, "You are not assigned as a priest.");
        }

        $parish = $priest->parish;
        if (!$parish) {
            abort(403, "No parish assigned to this priest.");
        }

        return view('priest.tithes.index', compact('parish'));
    }

    /**
     * Show tithe summary for a single parish
     */
    public function showParish(Parish $parish)
    {
        // Fetch SCCs under this parish
        $communities = $parish->communities;

        // Monthly parish total (PostgreSQL)
        $monthlyTotals = Tithe::where('parish_id', $parish->id)
            ->selectRaw("TO_CHAR(tithe_date, 'YYYY-MM') AS month, SUM(amount) AS total")
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->get();

        return view('priest.tithes.parish', compact('parish', 'communities', 'monthlyTotals'));
    }

    /**
     * Show tithe summary for a specific SCC within a parish
     */
    public function showScc(SmallCommunity $community)
    {
        $members = $community->members;
        $tithes = Tithe::where('small_community_id', $community->id)
            ->with('member')
            ->orderBy('tithe_date', 'DESC')
            ->get();

        $total = $tithes->sum('amount');
        return view('priest.tithes.scc', compact('community', 'members', 'tithes', 'total'));
    }

    /**
     * Show tithe contributions for a single member
     */
    public function showMember($memberId)
    {
        $tithes = Tithe::where('member_id', $memberId)->orderBy('tithe_date', 'DESC')->get();
        $total = $tithes->sum('amount');
        return view('priest.tithes.member', compact('tithes', 'total'));
    }
}
