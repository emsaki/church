<?php

namespace App\Http\Controllers\Priest;

use App\Models\Parish;
use Illuminate\Http\Request;
use App\Models\BaptismRecord;
use App\Http\Controllers\Controller;

class BaptismApprovalController extends Controller
{
    public function index()
    {
        // Only show records for parishes priest oversees
        $parishIds = auth()->user()->parishes->pluck('id');

        $records = BaptismRecord::whereIn('parish_id', $parishIds)
                    ->orWhereNull('parish_id')
                    ->with('member')
                    ->get();

        return view('priest.baptisms.index', compact('records'));
    }

    public function edit(BaptismRecord $record)
    {
        $parishes = Parish::all();
        return view('priest.baptisms.edit', compact('record', 'parishes'));
    }

    public function update(Request $request, BaptismRecord $record)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'certificate_number' => 'nullable|string',
            'baptism_date' => 'nullable|date',
            'parish_id' => 'nullable|exists:parishes,id',
        ]);

        $record->update($validated);

        // Auto-update member baptism flag
        if ($validated['status'] === 'approved') {
            $record->member->update([
                'is_baptised' => 1,
                'baptism_certificate_no' => $validated['certificate_number'],
            ]);
        }

        return back()->with('success', 'Baptism record updated.');
    }
}