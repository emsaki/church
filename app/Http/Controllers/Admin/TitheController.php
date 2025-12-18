<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tithe;
use App\Models\Member;
use App\Models\Parish;
use App\Models\SmallCommunity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TitheController extends Controller
{
    /**
     * Full tithe list + filters + totals.
     */
    public function index(Request $request)
    {
        $query = SmallCommunity::query()
            ->withCount('members')
            ->withSum('tithes', 'amount');

        // FILTER BY PARISH
        if ($request->filled('parish_id')) {
            $query->where('parish_id', $request->parish_id);
        }

        // FILTER BY SCC
        if ($request->filled('community_id')) {
            $query->where('id', $request->community_id);
        }

        // DATE FILTERS (filter tithes inside SCC)
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->whereHas('tithes', function($q) use ($request) {
                if ($request->filled('start_date')) {
                    $q->whereDate('tithe_date', '>=', $request->start_date);
                }
                if ($request->filled('end_date')) {
                    $q->whereDate('tithe_date', '<=', $request->end_date);
                }
            });
        }

        // Fetch SCCs
        $sccs = $query->orderBy('name')->paginate(20);

        // Total amount matching current filter set
        $totalAmount = Tithe::when($request->filled('parish_id'), function($q) use ($request) {
                $q->whereHas('member', fn($m) => $m->where('parish_id', $request->parish_id));
            })
            ->when($request->filled('community_id'), function($q) use ($request) {
                $q->where('small_community_id', $request->community_id);
            })
            ->when($request->filled('start_date'), function($q) use ($request) {
                $q->whereDate('tithe_date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function($q) use ($request) {
                $q->whereDate('tithe_date', '<=', $request->end_date);
            })
            ->sum('amount');

        return view('admin.tithes.index', [
            'sccs' => $sccs,
            'parishes' => Parish::orderBy('name')->get(),
            'communities' => SmallCommunity::orderBy('name')->get(),
            'totalAmount' => $totalAmount,
        ]);
    }

    public function create(Request $request)
    {
        $member = $request->filled('member')
            ? Member::findOrFail($request->member)
            : null;
        return view('admin.tithes.create', compact('member'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'  => 'required|exists:members,id',
            'amount'     => 'required|numeric|min:100',
            'tithe_date' => 'required|date',
            'notes'      => 'nullable'
        ]);

        $member = Member::findOrFail($validated['member_id']);

        Tithe::create([
            'member_id'          => $member->id,
            'small_community_id' => $member->small_community_id,
            'parish_id'          => $member->parish_id,
            'amount'             => $validated['amount'],
            'tithe_date'         => $validated['tithe_date'],
            'payment_date'       => $validated['tithe_date'],
            'notes'              => $validated['notes'],
            'recorded_by'        => auth()->id(),
            'verified'           => true
        ]);

        return redirect()
            ->route('admin.tithes.member.index', $member->id)
            ->with('success', 'Tithe recorded successfully.');
    }

    /**
     * Edit a tithe record.
     */
    public function edit(Tithe $tithe)
    {
        $members = Member::orderBy('first_name')->get();

        return view('admin.tithes.edit', compact('tithe', 'members'));
    }

    /**
     * Update tithe.
     */
    public function update(Request $request, Tithe $tithe)
    {
        $validated = $request->validate([
            'member_id'  => 'required|exists:members,id',
            'amount'     => 'required|numeric|min:100',
            'tithe_date' => 'required|date',
            'notes'      => 'nullable|string',
        ]);

        $tithe->update($validated);

        return redirect()
                ->route('admin.tithes.index')
                ->with('success', 'Tithe updated successfully.');
    }

    public function sccMembers(SmallCommunity $scc)
    {
        $members = Member::withSum('tithes', 'amount')
            ->where('small_community_id', $scc->id)
            ->get();

        return view('admin.tithes.scc_members', compact('scc', 'members'));
    }

    /**
     * Delete tithe.
     */
    public function destroy(Tithe $tithe)
    {
        $tithe->delete();

        return back()->with('success', 'Tithe deleted.');
    }

    /**
     * Mark tithe as verified by admin.
     */
    public function verify(Tithe $tithe)
    {
        $tithe->update(['verified' => true]);

        return back()->with('success', 'Tithe marked as verified.');
    }

    /**
     * Admin dashboard summary: charts + totals.
     */
    public function dashboard()
    {
        $monthlyTotals = Tithe::selectRaw("TO_CHAR(tithe_date, 'YYYY-MM') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->limit(12)
            ->get();

        $byParish = Parish::withSum('tithes', 'amount')->get();
        $byCommunity = SmallCommunity::withSum('tithes', 'amount')->get();
        $totalTithes = Tithe::sum('amount');

        return view('admin.tithes.dashboard', compact(
            'monthlyTotals',
            'byParish',
            'byCommunity',
            'totalTithes'
        ));
    }

    public function sccMember(Member $member)
    {
        $tithes = Tithe::where('member_id', $member->id)->latest()->get();
        $total = $tithes->sum('amount');

        return view('admin.tithes.member', compact('member', 'tithes', 'total'));
    }

}