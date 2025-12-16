<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\SmallCommunity;
use App\Http\Controllers\Controller;
use App\Models\SmallCommunityLeader;

class SmallCommunityLeaderController extends Controller
{
    public function edit(SmallCommunity $community)
    {
        $members = Member::where('small_community_id', $community->id)->get();
        $positions = Position::orderBy('order')->get();
        return view('admin.communities.assign_leader', compact('community', 'members', 'positions'));
    }

    public function show(SmallCommunity $community)
    {
        return view('admin.communities.show', compact('community'));
    }

    public function update(Request $request, SmallCommunity $community)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'position_id' => 'required|exists:positions,id',
        ]);

        // 1️⃣ Find Member
        $member = Member::findOrFail($validated['member_id']);

        // 2️⃣ Does this member have a user account already?
        $user = \App\Models\User::where('email', $member->email)->first();

        if (!$user) {
            // 3️⃣ Create user account automatically
            $user = \App\Models\User::create([
                'name' => $member->first_name . ' ' . $member->last_name,
                'email' => $member->email ?? ('leader'.$member->id.'@auto.local'),
                'phone' => $member->phone,
                'password' => bcrypt('password123'), // temp password
            ]);
        }

        // 4️⃣ Assign SCC Leader role
        if (!$user->hasRole('scc_leader')) {
            $user->assignRole('scc_leader');
        }

        // 5️⃣ Save leader assignment
        SmallCommunityLeader::updateOrCreate(
            ['small_community_id' => $community->id],
            [
                'member_id' => $member->id,
                'user_id'   => $user->id,
                'position_id' => $validated['position_id'],
            ]
        );

        return redirect()
            ->route('admin.communities.index')
            ->with('success', 'SCC leader assigned and account created.');
    }
}
