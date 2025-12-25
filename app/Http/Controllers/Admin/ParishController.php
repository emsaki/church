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
        return view('admin.parishes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email',
            'phone'    => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
        ]);

        Parish::create($request->only(['name', 'email', 'phone', 'location']));

        return redirect()
            ->route('admin.parishes.index')
            ->with('success', 'Parish created successfully.');
    }

    public function show(Parish $parish)
    {
        $parish->load('priestHistory.priest');
        return view('admin.parishes.show', compact('parish'));
    }

    public function edit(Parish $parish)
    {
        $priests = Priest::orderBy('id')->get();
        return view('admin.parishes.edit', compact('parish', 'priests'));
    }

    public function update(Request $request, Parish $parish)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'priest_id' => 'nullable|exists:priests,id',
        ]);

        // Handle assignment history
        if ($parish->priest_id != $validated['priest_id']) {

            // Close previous assignment
            ParishPriestHistory::where('parish_id', $parish->id)
                ->whereNull('assigned_to')
                ->update(['assigned_to' => now()]);

            // Add new assignment
            if ($validated['priest_id']) {
                ParishPriestHistory::create([
                    'parish_id' => $parish->id,
                    'priest_id' => $validated['priest_id'],
                    'assigned_from' => now(),
                ]);
            }
        }

        $parish->update($validated);

        return redirect()->route('admin.parishes.index')
            ->with('success', 'Parish updated successfully.');
    }

    public function destroy(Parish $parish)
    {
        $parish->delete();

        return redirect()->route('admin.parishes.index')
            ->with('success', 'Parish deleted.');
    }

    public function assign(Parish $parish)
    {
        $priests = Priest::orderBy('id')->get();
        $activePriests = $parish->activePriests;
        $history = $parish->priestHistory()->with('priest')->get();
        return view('admin.parishes.assign', compact(
            'parish', 'priests', 'activePriests', 'history'
        ));
    }

    public function storeAssignment(Request $request, Parish $parish)
    {
        $request->validate([
            'priest_id' => 'required|exists:priests,id'
        ]);

        // Close existing active assignments
        ParishPriestHistory::where('parish_id', $parish->id)
            ->whereNull('assigned_to')
            ->update(['assigned_to' => now()]);

        // Add new assignment
        ParishPriestHistory::create([
            'parish_id' => $parish->id,
            'priest_id' => $request->priest_id,
            'assigned_from' => now(),
        ]);
        return back()->with('success', 'Priest assigned successfully.');
    }

    public function unassign($parishId, $priestId)
    {
        ParishPriestHistory::where('parish_id', $parishId)
            ->where('priest_id', $priestId)
            ->whereNull('assigned_to')
            ->update(['assigned_to' => now()]);

        return back()->with('success', 'Priest unassigned from parish.');
    }

}