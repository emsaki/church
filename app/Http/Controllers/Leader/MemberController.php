<?php

namespace App\Http\Controllers\Leader;

use App\Models\Member;
use App\Models\Parish;
use Illuminate\Http\Request;
use App\Models\SmallCommunity;
use App\Http\Controllers\Controller;
use App\Models\SmallCommunityLeader;

class MemberController extends Controller
{
    public function __construct()
    {
        // Admin can do everything
        $this->middleware('role:admin')->only(['destroy']);

        // SCC Leaders restricted access
        // $this->middleware('role:scc_leader')->only([
        //     'index', 'create', 'store', 'edit', 'update'
        // ]);
    }

    /* ============================================================
     *  INDEX – Admin sees all, SCC Leader sees ONLY their members
     * ============================================================ */
    public function index(Request $request)
    {
        
        $leaderScc = SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if(!$leaderScc, 403, "You are not assigned to an SCC.");
        $sccId = $leaderScc->small_community_id;
        $members = Member::where('small_community_id', $sccId)
            ->with(['parish', 'community'])
            ->orderBy('first_name')
            ->paginate(20);

        return view('leader.members.index', [
            'members' => $members,
            'parishes' => Parish::where('id', $leaderScc->community->parish_id)->get(),
            'communities' => SmallCommunity::where('id', $sccId)->get(),
        ]);

        // ADMIN FILTERING
        $query = Member::with(['parish', 'community']);

        if ($request->filled('parish_id')) {
            $query->where('parish_id', $request->parish_id);
        }

        if ($request->filled('community_id')) {
            $query->where('small_community_id', $request->community_id);
        }

        $members = $query->orderBy('first_name')->paginate(20);

        return view('leader.members.index', [
            'members' => $members,
            'parishes' => Parish::all(),
            'communities' => SmallCommunity::all(),
        ]);
    }

    /* ============================================================
     *  CREATE – Admin chooses Parish/SCC; leader locked to their SCC
     * ============================================================ */
    public function create()
    {
        // SCC Leader
        $leader = SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if(!$leader, 403);

        $scc = $leader->community;

        return view('leader.members.create', [
            'parishes'       => Parish::where('id', $scc->parish_id)->get(),
            'communities'    => SmallCommunity::where('id', $scc->id)->get(),
            'leader_scc_id'  => $scc->id,
        ]);
    }

    /* ============================================================
     *  STORE
     * ============================================================ */
    public function store(Request $request)
    {
        // Force SCC leader's SCC + Parish
        $leader = SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if(!$leader, 403);

        $scc = $leader->community;

        $request->merge([
            'small_community_id' => $scc->id,
            'parish_id'          => $scc->parish_id,
        ]);

        $validated = $request->validate([
            'first_name' => 'required|string|max:120',
            'middle_name' => 'nullable|string|max:120',
            'last_name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'is_baptised' => 'boolean',
            'baptism_certificate_no' => 'nullable|string|max:255',
            'parish_id' => 'required|integer',
            'small_community_id' => 'required|integer',
        ]);

        Member::create($validated);

        return $this->redirectAfterSave()
            ->with('success', 'Member registered successfully.');
    }

    /* ============================================================
     *  EDIT
     * ============================================================ */
    public function edit(Member $member)
    {
        // SCC Leader can edit only their SCC
        $leader = SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if(!$leader, 403);
        $sccId = $leader->small_community_id;
        abort_unless($member->small_community_id == $sccId, 403);
        $scc = $leader->community;
        return view('leader.members.edit', [
            'member' => $member,
            'parishes' => Parish::where('id', $scc->parish_id)->get(),
            'communities' => SmallCommunity::where('id', $scc->id)->get(),
            'leader_scc_id' => $scc->id,
        ]);

        // Admin
        return view('leader.members.edit', [
            'member' => $member,
            'parishes' => Parish::all(),
            'communities' => SmallCommunity::all(),
        ]);
    }

    /* ============================================================
     *  UPDATE
     * ============================================================ */
    public function update(Request $request, Member $member)
    {
        $leader = SmallCommunityLeader::getLeaderScc(auth()->id());
        abort_if(!$leader, 403);

        $scc = $leader->community;

        abort_unless($member->small_community_id == $scc->id, 403);

        $request->merge([
            'small_community_id' => $scc->id,
            'parish_id'          => $scc->parish_id,
        ]);

        $validated = $request->validate([
            'first_name' => 'required|string|max:120',
            'middle_name' => 'nullable|string|max:120',
            'last_name' => 'required|string|max:120',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'is_baptised' => 'boolean',
            'baptism_certificate_no' => 'nullable|string|max:255',
            'parish_id' => 'required|integer',
            'small_community_id' => 'required|integer',
        ]);

        $member->update($validated);

        return $this->redirectAfterSave()
            ->with('success', 'Member updated successfully.');
    }

    /* ============================================================
     *  DELETE (Admin only)
     * ============================================================ */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('leader.members.index')
            ->with('success', 'Member deleted.');
    }

    /* ============================================================
     *  Helper: Correct redirect based on user role
     * ============================================================ */
    private function redirectAfterSave()
    {
        return auth()->user()->hasRole('scc_leader')
            ? redirect()->route('leader.members.index')
            : redirect()->route('leader.members.index');
    }

    public function profile(Member $member)
    {
        // SCC leader can only view their SCC members
        $sccId = SmallCommunityLeader::getLeaderSccId(auth()->id());

        if ($member->small_community_id != $sccId) {
            abort(403, 'Not allowed.');
        }
        $totals = $member->tithes->sum('amount');
        return view('leader.members.profile', [
            'member' => $member->load(['parish', 'community']),
        ]);
    }

}