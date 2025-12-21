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

    public function approve(Request $request, $id)
    {
        $request->validate([
            'approval_status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $record = BaptismRecord::findOrFail($id);

        $record->status = $request->approval_status;
        $record->notes  = $request->notes;
        $record->approved_by = auth()->id();
        $record->approved_at = now();
        $record->save();

        return redirect()
                ->route('priest.baptisms.index', $record->id)
                ->with('success', 'Baptism request updated successfully.');
    }

    public function approveForm(BaptismRecord $record)
    {
         $parishes = Parish::all();
        return view('priest.baptisms.approve', compact('record', 'parishes'));
    }

    public function getRecords()
    {
        $records = BaptismRecord::with('member')->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('priest.baptisms.records', compact('records'));
    }

    public function editRecord(BaptismRecord $record)
    {
        return view('priest.baptisms.records_edit', compact('record'));
    }

    public function updateRecord(Request $request, BaptismRecord $record)
    {
        $request->validate([
            'baptism_date' => 'required|date',
            'certificate_number' => 'nullable|string|max:100',
            // 'parish_id' => 'required|integer',
            // 'notes' => 'nullable|string',
        ]);

        $record->update($request->all());

        return redirect()
            ->route('priest.baptisms.records')
            ->with('success', 'Baptism record updated successfully.');
    }

}