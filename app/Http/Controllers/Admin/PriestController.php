<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Priest;
use Illuminate\Http\Request;
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
        return view('admin.priests.create');
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

        // Build full name
        $fullName = trim($validated['first_name'] . ' ' . ($validated['middle_name'] ?? '') . ' ' . $validated['last_name']);

        /** 1️⃣ Create User account */
        $user = User::create([
            'name'     => $fullName,
            'email'    => $validated['email'],
            'phone'    => $validated['phone'],
            'role'     => 'priest',
            'password' => bcrypt('password123'),
        ]);

        /** 2️⃣ Assign Priest role */
        $user->assignRole('priest');

        /** 3️⃣ Create Priest record */
        $priest = Priest::create($request->all());
        $priest->update(['user_id' => $user->id]);

        return redirect()
            ->route('admin.priests.index')
            ->with('success', 'Priest account created successfully.');
    }


    public function edit(Priest $priest)
    {
        return view('admin.priests.edit', compact('priest'));
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
}