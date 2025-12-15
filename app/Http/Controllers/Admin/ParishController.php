<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parish;
use App\Models\Priest;
use Illuminate\Http\Request;
use App\Models\ParishPriestHistory;
use App\Http\Controllers\Controller;

class ParishController extends Controller
{
    public function index()
    {
        $parishes = Parish::all();
        return view('admin.parishes.index', compact('parishes'));
    }

    public function create()
    {
        $priests = Priest::where('active', true)->get();
        return view('admin.parishes.create', compact('priests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'priest_id' => 'nullable|exists:priests,id',
        ]);

        $parish = Parish::create($request->all());

        if ($request->priest_id) {
            ParishPriestHistory::create([
                'parish_id' => $parish->id,
                'priest_id' => $request->priest_id,
                'assigned_from' => now(),
            ]);
        }

        return redirect()->route('admin.parishes.index')
            ->with('success', 'Parish created successfully.');
    }

    public function show(Parish $parish)
    {
        $parish->load('priestHistory.priest');
        return view('admin.parishes.show', compact('parish'));
    }

    public function edit(Parish $parish)
    {
        $priests = \App\Models\Priest::orderBy('first_name')->get();
        return view('admin.parishes.edit', compact('parish', 'priests'));
    }

    public function update(Request $request, Parish $parish)
    {
        $request->validate([
            'name' => 'required',
            'priest_id' => 'nullable|exists:priests,id',
        ]);

        // If priest has changed
        if ($parish->priest_id != $request->priest_id) {

            // Close old assignment
            if ($parish->priest_id) {
                ParishPriestHistory::where('parish_id', $parish->id)
                    ->whereNull('assigned_to')
                    ->update(['assigned_to' => now()]);
            }

            // Start new assignment
            if ($request->priest_id) {
                ParishPriestHistory::create([
                    'parish_id' => $parish->id,
                    'priest_id' => $request->priest_id,
                    'assigned_from' => now(),
                ]);
            }
        }

        // Update parish table
        $parish->update($request->all());

        return redirect()->route('admin.parishes.index')
            ->with('success', 'Parish updated successfully.');
    }

    public function destroy(Parish $parish)
    {
        $parish->delete();

        return redirect()->route('admin.parishes.index')
            ->with('success', 'Parish deleted.');
    }
}