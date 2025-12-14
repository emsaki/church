<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parish;
use App\Models\SmallCommunity;
use Illuminate\Http\Request;

class SmallCommunityController extends Controller
{
    public function index()
    {
        $communities = SmallCommunity::with('parish')->get();
        return view('admin.communities.index', compact('communities'));
    }

    public function create()
    {
        $parishes = Parish::all();
        return view('admin.communities.create', compact('parishes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parish_id' => 'required|exists:parishes,id',
            'name' => 'required|string|max:255',
            'leader_name' => 'nullable|string|max:255',
            'leader_phone' => 'nullable|string|max:20',
        ]);

        SmallCommunity::create($request->all());

        return redirect()->route('admin.communities.index')
            ->with('success', 'Community created successfully.');
    }

    public function edit(SmallCommunity $community)
    {
        $parishes = Parish::all();
        return view('admin.communities.edit', compact('community', 'parishes'));
    }

    public function update(Request $request, SmallCommunity $community)
    {
        $request->validate([
            'parish_id' => 'required|exists:parishes,id',
            'name' => 'required|string|max:255',
            'leader_name' => 'nullable|string|max:255',
            'leader_phone' => 'nullable|string|max:20',
        ]);

        $community->update($request->all());

        return redirect()->route('admin.communities.index')
            ->with('success', 'Community updated successfully.');
    }

    public function destroy(SmallCommunity $community)
    {
        $community->delete();
        return redirect()->route('admin.communities.index')
            ->with('success', 'Community deleted successfully.');
    }
}