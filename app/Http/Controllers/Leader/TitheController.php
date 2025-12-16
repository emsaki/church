<?php

namespace App\Http\Controllers\Leader;

use App\Models\Tithe;
use App\Models\Member;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\SmallCommunityLeader;

class TitheController extends Controller
{
    public function index()
    {
        $leaderScc = auth()->user()->leaderScc();
        if (!$leaderScc) {
            abort(403, "No SCC assigned.");
        }

        $members = $leaderScc->members;
        $tithes = Tithe::with('member')
            ->where('small_community_id', $leaderScc->id)
            ->latest()
            ->get();

        $totals = $tithes->sum('amount');
        $topContributors = Tithe::selectRaw('member_id, SUM(amount) as total')
            ->where('small_community_id', $leaderScc->id)
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->with('member')
            ->limit(5)
            ->get();
        return view('leader.tithes.index', compact('members', 'tithes', 'totals', 'leaderScc', 'topContributors'));
    }

    public function create()
    {
        $leaderScc = auth()->user()->leaderScc;
        if (!$leaderScc || !$leaderScc->community) {
            abort(403, "You are not assigned to an SCC.");
        }
         $members = $leaderScc->community->members;
        return view('leader.tithes.create', compact('members'));
    }

    public function store(Request $request)
    {
        $leaderScc = auth()->user()->leaderScc;
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount'    => 'required|numeric|min:100',
            'tithe_date'=> 'required|date',
            'notes'     => 'nullable'
        ]);

        Tithe::create([
            'member_id'          => $validated['member_id'],
            'small_community_id' => $leaderScc->community->id,
            'parish_id'          => $leaderScc->community->parish_id,
            'amount'             => $validated['amount'],
            'tithe_date'         => $validated['tithe_date'],
            'payment_date'         => $validated['tithe_date'],
            'notes'              => $validated['notes'] ?? null,
            'recorded_by'        => auth()->id(),
        ]);

        return redirect()->route('leader.tithes.index')->with('success', 'Tithe recorded successfully');
    }

    public function edit(Tithe $tithe)
    {
        $leaderScc = SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if($tithe->member->small_community_id != $leaderScc->small_community_id, 403);
        $members = Member::where('small_community_id', $leaderScc->small_community_id)->get();
        return view('leader.tithes.edit', compact('tithe', 'members'));
    }

    public function update(Request $request, Tithe $tithe)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:100',
            'tithe_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $tithe->update($validated);
        return redirect()->route('leader.tithes.index')->with('success', 'Tithe updated successfully.');
    }

    public function destroy(Tithe $tithe)
    {
        $tithe->delete();
        return redirect()->route('leader.tithes.index')->with('success', 'Tithe deleted.');
    }

    public function monthlyTotals()
    {
        $leaderScc = SmallCommunityLeader::getLeaderScc(auth()->id());
        $monthlyTotals = Tithe::selectRaw("DATE_FORMAT(tithe_date, '%Y-%m') AS month, SUM(amount) AS total")
            ->whereHas('member', fn($q) => 
                $q->where('small_community_id', $leaderScc->small_community_id)
            )
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->get();

        return view('leader.tithes.monthly', compact('monthlyTotals'));
    }

    public function receipt(Tithe $tithe)
    {
        $pdf = Pdf::loadView('leader.tithes.receipt', ['tithe' => $tithe]);

        return $pdf->download('tithe-receipt-'.$tithe->id.'.pdf');
    }

    public function sccMember(Member $member)
    {
        $leaderScc = auth()->user()->leaderScc;
        if ($member->small_community_id !== $leaderScc->small_community_id) {
            abort(403);
        }

        $tithes = Tithe::where('member_id', $member->id)->latest()->get();
        $totals = $tithes->sum('amount');
        return view('leader.tithes.member', compact('member', 'tithes', 'leaderScc', 'totals'));
    }

    public function dashboard()
    {
        $leaderScc = auth()->user()->leaderScc;

        if (!$leaderScc) {
            abort(403, "You are not assigned to an SCC.");
        }

        $sccId = $leaderScc->small_community_id ?? $leaderScc->id;

        // WEEK SUMMARY
        $weekTotal = Tithe::where('small_community_id', $sccId)
            ->whereBetween('tithe_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->sum('amount');

        // MONTH SUMMARY
        $monthTotal = Tithe::where('small_community_id', $sccId)
            ->whereMonth('tithe_date', now()->month)
            ->whereYear('tithe_date', now()->year)
            ->sum('amount');

        // YEAR SUMMARY
        $yearTotal = Tithe::where('small_community_id', $sccId)
            ->whereYear('tithe_date', now()->year)
            ->sum('amount');

        // Monthly trend chart data
        $monthlyTrend = Tithe::where('small_community_id', $sccId)
            ->selectRaw("TO_CHAR(tithe_date, 'YYYY-MM') AS month, SUM(amount) AS total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top contributors
        $topMembers = Tithe::with('member')
            ->where('small_community_id', $sccId)
            ->selectRaw('member_id, SUM(amount) as total')
            ->groupBy('member_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('leader.tithes.dashboard', compact(
            'weekTotal',
            'monthTotal',
            'yearTotal',
            'monthlyTrend',
            'topMembers',
            'leaderScc'
        ));
    }

}

