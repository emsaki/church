<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Parish;
use App\Models\Priest;
use Illuminate\Http\Request;
use App\Models\ParishPriestHistory;
use App\Http\Controllers\Controller;

class PriestController extends Controller
{
    public function index()
    {
        $priests = Priest::all();
        return view('admin.priests.index', compact('priests'));
    }

    public function create()
    {
        $parishes = Parish::all();
        return view('admin.priests.create', compact('parishes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_name'     => 'nullable|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'phone'           => 'required|string|max:50',
            'ordination_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'active'          => 'nullable|integer',
            'parish_id'       => 'nullable|exists:parishes,id',
        ]);

        $fullName = trim($validated['first_name'].' '.($validated['middle_name'] ?? '').' '.$validated['last_name']);
        $user = User::create([
            'name'     => $fullName,
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'password' => bcrypt('password123'),
        ]);

        $user->assignRole('priest');
        $priest = Priest::create([
            'first_name'      => $validated['first_name'],
            'middle_name'     => $validated['middle_name'] ?? null,
            'last_name'       => $validated['last_name'],
            'phone'           => $validated['phone'],
            'email'           => $validated['email'],
            'ordination_year' => $validated['ordination_year'],
            'active'          => $validated['active'] ?? 1,
            'user_id'         => $user->id,
        ]);

        if ($request->filled('parish_id')) {
            ParishPriestHistory::create([
                'parish_id'      => $request->parish_id,
                'priest_id'      => $priest->id,
                'assigned_from'  => now(),
                'assigned_to'    => null,
            ]);
        }

        return redirect()
            ->route('admin.priests.index')
            ->with('success', 'Priest created successfully.');
    }

    public function edit(Priest $priest)
    {
        $parishes = Parish::all();
        return view('admin.priests.edit', compact('priest', 'parishes'));
    }

    public function update(Request $request, Priest $priest)
    {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $priest->user_id,
            'phone'       => 'required|string|max:50',
            'ordination_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        // Build new full name
        $fullName = trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']);

        /** Update Priest record */
        $priest->update([
            'first_name'      => $validated['first_name'],
            'middle_name'     => $validated['middle_name'] ?? null,
            'last_name'       => $validated['last_name'],
            'ordination_year' => $validated['ordination_year'] ?? null,
            'phone'           => $validated['phone'],
        ]);

        /** Update linked User record */
        $priest->user->update([
            'name'  => $fullName,
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        return redirect()
            ->route('admin.priests.index')
            ->with('success', 'Priest updated successfully.');
    }
    public function show(Priest $priest)
    {
        // Load all parishes this priest has served in, incl. history
        $priest->load('parishes', 'user');

        return view('admin.priests.show', compact('priest'));
    }

    public function toggleStatus(Priest $priest)
    {
        $priest->active = !$priest->active;
        $priest->save();

        return back()->with('success', 'Priest status updated.');
    }

    public function assignForm(Priest $priest)
    {
        $parishes = Parish::orderBy('name')->get();
        $assignments = ParishPriestHistory::with('parish')
            ->where('priest_id', $priest->id)
            ->orderBy('assigned_from', 'desc')
            ->get();

        return view('admin.priests.assign', compact('priest', 'parishes', 'assignments'));
    }

    public function assign(Request $request, Priest $priest)
    {
        $request->validate([
            'parish_id' => 'required|exists:parishes,id',
        ]);

        ParishPriestHistory::create([
            'parish_id' => $request->parish_id,
            'priest_id' => $priest->id,
            'assigned_from' => now(),
        ]);

        return back()->with('success', 'Priest assigned successfully.');
    }

    public function removeAssignment(Priest $priest, ParishPriestHistory $history)
    {
        $history->update(['assigned_to' => now()]);

        return back()->with('success', 'Assignment ended.');
    }

    public function resetPassword(Priest $priest)
    {
        $newPass = "Priest@" . rand(1000,9999);

        $priest->user->update(['password' => bcrypt($newPass)]);

        return back()->with('success', "New password is: $newPass");
    }
}