<?php

namespace App\Http\Controllers\Leader;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\BaptismRecord;
use App\Http\Controllers\Controller;
use App\Models\SmallCommunityLeader;

class BaptismController extends Controller
{
    public function index()
    {
        $records = BaptismRecord::where('submitted_by', auth()->id())->with('member')->get();

        return view('leader.baptisms.index', compact('records'));
    }

    public function create()
    {
        $leadersScc = SmallCommunityLeader::getLeaderScc(auth()->id());
        $members = Member::where('small_community_id', $leadersScc->small_community_id)
                        ->orderBy('first_name')
                        ->get();
        return view('leader.baptisms.create', compact('members'));
    }

    public function store(Request $request)
    {
        // Get SCC of the logged-in leader
        $leaderScc = \App\Models\SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if(!$leaderScc, 403, "You are not assigned to an SCC.");

        $parishId = $leaderScc->community->parish_id;
        if ($request->is_member == '1') {
            $validated = $request->validate([
                'member_id' => 'required|exists:members,id',
                'notes'     => 'nullable|string'
            ]);

            BaptismRecord::create([
                'member_id'    => $validated['member_id'],
                'submitted_by' => auth()->id(),
                'status'       => 'pending',
                'notes'        => $validated['notes'] ?? null,
                'parish_id'    => $parishId,
            ]);

        } else {
            $validated = $request->validate([
                'full_name'   => 'required|string',
                'dob'         => 'nullable|date',
                'father_name' => 'nullable|string',
                'mother_name' => 'nullable|string',
                'notes'       => 'nullable|string',
            ]);

            BaptismRecord::create([
                'full_name'   => $validated['full_name'],
                'dob'         => $validated['dob'] ?? null,
                'father_name' => $validated['father_name'] ?? null,
                'mother_name' => $validated['mother_name'] ?? null,
                'submitted_by'=> auth()->id(),
                'status'      => 'pending',
                'notes'       => $validated['notes'] ?? null,
                'parish_id'   => $parishId,
            ]);
        }

        return redirect()
            ->route('leader.baptisms.index')
            ->with('success', 'Baptism request submitted.');
    }
}