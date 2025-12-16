<?php

namespace App\Http\Controllers\Priest;

use App\Models\Parish;
use Illuminate\Http\Request;
use App\Models\BaptismRecord;
use App\Http\Controllers\Controller;

class BaptismController extends Controller
{
    public function index()
    {
        $priest = auth()->user()->priest;

        if (!$priest) {
            abort(403, "Priest not linked to priest profile.");
        }

        $parishIds = $priest->parishes->pluck('id');
        $records = BaptismRecord::whereIn('parish_id', $parishIds)
            ->whereIn('status', ['pending', 'approved'])
            ->with(['member', 'submitter'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('priest.baptisms.index', compact('records'));
    }

    // public function index()
    // {
    //     // Only show records for parishes priest oversees
    //     $parishIds = auth()->user()->parishes->pluck('id');

    //     $records = BaptismRecord::whereIn('parish_id', $parishIds)
    //                 ->orWhereNull('parish_id')
    //                 ->with('member')
    //                 ->get();

    //     return view('priest.baptisms.index', compact('records'));
    // }

    public function show(BaptismRecord $record)
    {
        return view('priest.baptisms.show', compact('record'));
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

    public function approveForm(BaptismRecord $record)
    {
         $parishes = Parish::all();
        return view('priest.baptisms.approve', compact('record', 'parishes'));
    }

    public function approve(Request $request, $record)
    {
        $validated = $request->validate([
            'certificate_number' => 'required|string|max:255',
            'baptism_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $baptism_record = BaptismRecord::findOrFail($record);
        $baptism_record->update([
            'certificate_number' => $validated['certificate_number'],
            'baptism_date' => $validated['baptism_date'],
            'status' =>  $validated['status'],
            'notes' => $validated['notes'] ?? $baptism_record->notes,
        ]);

        return redirect()->route('priest.baptisms.index')
            ->with('success', 'Baptism approved successfully.');
    }
}