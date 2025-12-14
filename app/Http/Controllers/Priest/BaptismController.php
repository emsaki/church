<?php

namespace App\Http\Controllers\Priest;

use App\Http\Controllers\Controller;
use App\Models\BaptismRecord;
use Illuminate\Http\Request;

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

    public function show(BaptismRecord $record)
    {
        return view('priest.baptisms.show', compact('record'));
    }

    public function approveForm(BaptismRecord $record)
    {
        return view('priest.baptisms.approve', compact('record'));
    }

    public function approve(Request $request, BaptismRecord $record)
    {
        $validated = $request->validate([
            'certificate_number' => 'required|string|max:255',
            'baptism_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $record->update([
            'certificate_number' => $validated['certificate_number'],
            'baptism_date' => $validated['baptism_date'],
            'status' => 'baptized',
            'notes' => $validated['notes'] ?? $record->notes,
        ]);

        return redirect()->route('priest.baptisms.index')
            ->with('success', 'Baptism approved successfully.');
    }
}