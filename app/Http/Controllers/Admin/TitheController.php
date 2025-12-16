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
        $query = Tithe::with(['member.parish', 'member.community', 'recorder']);

        // Optional filters
        if ($request->filled('parish_id')) {
            $query->whereHas('member', fn($q) =>
                $q->where('parish_id', $request->parish_id)
            );
        }

        if ($request->filled('community_id')) {
            $query->whereHas('member', fn($q) =>
                $q->where('small_community_id', $request->community_id)
            );
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tithe_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tithe_date', '<=', $request->end_date);
        }

        // Paginated results
        $tithes = $query->latest()->paginate(25);

        // Totals for footer
        $totalAmount = $query->sum('amount');

        return view('admin.tithes.index', [
            'tithes' => $tithes,
            'parishes' => Parish::orderBy('name')->get(),
            'communities' => SmallCommunity::orderBy('name')->get(),
            'totalAmount' => $totalAmount,
        ]);
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
        $monthlyTotals = Tithe::selectRaw("DATE_FORMAT(tithe_date, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month', 'DESC')
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
}