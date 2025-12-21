<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BaptismRecord;
use App\Http\Controllers\Controller;

class BaptismController extends Controller
{
    public function getRecords()
    {
        $records = BaptismRecord::with('member')->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.baptisms.records', compact('records'));
    }

    public function editRecord(BaptismRecord $record)
    {
        return view('admin.baptisms.records_edit', compact('record'));
    }

    public function updateRecord(Request $request, BaptismRecord $record)
    {
        $request->validate([
            'baptism_date' => 'required|date',
            'certificate_number' => 'nullable|string|max:100',
        ]);

        $record->update($request->all());
        return redirect()
            ->route('admin.baptisms.records')
            ->with('success', 'Baptism details updated.');
    }

}
