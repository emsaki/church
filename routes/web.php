<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ParishController;
use App\Http\Controllers\Admin\PriestController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Leader\BaptismController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SmallCommunityController;
use App\Http\Controllers\Leader\LeaderDashboardController;
use App\Http\Controllers\Priest\BaptismApprovalController;
use App\Http\Controllers\Admin\SmallCommunityLeaderController;

// ---------------------------------------------------------------
// PUBLIC WELCOME PAGE
// ---------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// AJAX route: Load communities by parish (for dropdown)
Route::get('/communities/by-parish/{parish}', function ($parishId) {
    return \App\Models\SmallCommunity::where('parish_id', $parishId)->get();
});

// ---------------------------------------------------------------
// AUTHENTICATED USERS (OTP + Dashboard)
// ---------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // OTP step
    Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'members'     => \App\Models\Member::count(),
            'sccCount'    => \App\Models\SmallCommunity::count(),
            'parishCount' => \App\Models\Parish::count(),
            'priestCount' => \App\Models\Priest::count(),
        ]);
    })->middleware(['auth', 'verified.phone'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------------------------
// ADMIN ROUTES
// ---------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Parish
        Route::get('parishes/{parish}/members', [MemberController::class, 'byParish'])->name('parishes.members');
        // Communities
        Route::get('communities/{community}/members', [MemberController::class, 'byCommunity'])->name('communities.members');
        
        // Select SCC leader view
        Route::get('communities/select-leader', function () {
            return view('admin.communities.select-leader', [
                'communities' => \App\Models\SmallCommunity::with('parish')->get()
                ]);
        })->name('communities.select');
            
        // Assign SCC leader
        Route::get('communities/{community}/leader', [SmallCommunityLeaderController::class, 'edit'])->name('communities.leader');
        Route::post('communities/{community}/leader', [SmallCommunityLeaderController::class, 'update'])->name('communities.leader.update');
        Route::resource('communities', SmallCommunityController::class);
        Route::get('/members/{member}/profile', [MemberController::class, 'profile'])->name('members.profile');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            
        Route::resource('parishes', ParishController::class);
        // Priests
        Route::resource('priests', PriestController::class);
        // Members
        Route::resource('members', MemberController::class);

        // User Roles
        Route::get('/roles', [UserRoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{user}/edit', [UserRoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{user}', [UserRoleController::class, 'update'])->name('roles.update');

        // Positions
        Route::resource('positions', PositionController::class);
        // TITHE MANAGEMENT ROUTES
        Route::get('/tithes', [\App\Http\Controllers\Admin\TitheController::class, 'index'])->name('tithes.index');
        Route::get('/tithes/{tithe}/edit', [\App\Http\Controllers\Admin\TitheController::class, 'edit'])->name('tithes.edit');
        Route::put('/tithes/{tithe}', [\App\Http\Controllers\Admin\TitheController::class, 'update'])->name('tithes.update');
        Route::delete('/tithes/{tithe}', [\App\Http\Controllers\Admin\TitheController::class, 'destroy'])->name('tithes.destroy');
        Route::get('/tithes/dashboard', [App\Http\Controllers\Admin\TitheDashboardController::class, 'index'])->name('tithes.dashboard');
        Route::put('/tithes/{tithe}/verify', [App\Http\Controllers\Admin\TitheController::class, 'verify'])->name('tithes.verify');
    });

// ---------------------------------------------------------------
// PRIEST ROUTES
// ---------------------------------------------------------------
Route::middleware(['auth', 'role:priest'])
    ->prefix('priest')
    ->name('priest.')
    ->group(function () {
        Route::get('/dashboard', function () {
            $user = auth()->user();
            $priest = $user->priest;

            // Avoid null issues
            $parishes = $priest?->parishes ?? collect();
            $parishIds = $parishes->pluck('id');
            return view('priest.dashboard', [
                'parishes'     => $parishes,
                'sccCount'     => \App\Models\SmallCommunity::whereIn('parish_id', $parishIds)->count(),
                'memberCount'  => \App\Models\Member::whereIn('parish_id', $parishIds)->count(),
                'baptised'     => \App\Models\Member::whereIn('parish_id', $parishIds)->where('is_baptised', 1)->count(),
            ]);
        })->name('dashboard');
        // Baptisms (Priest)
        Route::get('/baptisms', [\App\Http\Controllers\Priest\BaptismController::class, 'index'])->name('baptisms.index');
        Route::get('/baptisms/{record}', [\App\Http\Controllers\Priest\BaptismController::class, 'show'])->name('baptisms.show');
        Route::get('/baptisms/{record}/approve', [\App\Http\Controllers\Priest\BaptismController::class, 'approveForm'])->name('baptisms.approve');
        Route::put('/baptisms/{record}/approve', [\App\Http\Controllers\Priest\BaptismController::class, 'approve'])->name('baptisms.approve.save');

        // Tithes
        Route::get('/tithes', [\App\Http\Controllers\Priest\TitheReportController::class, 'index'])->name('tithes.index');
        Route::get('/tithes/parish/{parish}', [\App\Http\Controllers\Priest\TitheReportController::class, 'showParish'])->name('tithes.parish');
        Route::get('/tithes/scc/{community}', [\App\Http\Controllers\Priest\TitheReportController::class, 'showScc'])->name('tithes.scc');
        Route::get('/tithes/member/{member}', [\App\Http\Controllers\Priest\TitheReportController::class, 'showMember'])->name('tithes.member');
    });

// ---------------------------------------------------------------
// SCC LEADER ROUTES
// ---------------------------------------------------------------
Route::middleware(['auth', 'role:scc_leader'])
    ->prefix('leader')
    ->name('leader.')
    ->group(function () {

        Route::get('/dashboard', [LeaderDashboardController::class, 'index'])->name('dashboard');

        // TITHES
        Route::get('/tithes', [\App\Http\Controllers\Leader\TitheController::class, 'index'])->name('tithes.index');
        Route::get('/tithes/create', [\App\Http\Controllers\Leader\TitheController::class, 'create'])->name('tithes.create');
        Route::get('/tithes/scc_member/{member}', [\App\Http\Controllers\Leader\TitheController::class, 'sccMember'])->name('tithes.scc_member');
        Route::get('/member/profile/{member}', [MemberController::class, 'profile'])->name('members.profile');
        Route::post('/tithes', [\App\Http\Controllers\Leader\TitheController::class, 'store'])->name('tithes.store');
        Route::get('/tithes/{tithe}/edit', [\App\Http\Controllers\Leader\TitheController::class, 'edit'])->name('tithes.edit');
        Route::put('/tithes/{tithe}', [\App\Http\Controllers\Leader\TitheController::class, 'update'])->name('tithes.update');
        Route::delete('/tithes/{tithe}', [\App\Http\Controllers\Leader\TitheController::class, 'destroy'])->name('tithes.destroy');
        Route::get('/tithes/{tithe}/receipt', [\App\Http\Controllers\Leader\TitheController::class, 'receipt'])->name('tithes.receipt');
        Route::get('/tithes/dashboard', [\App\Http\Controllers\Leader\TitheController::class, 'dashboard'])->name('tithes.dashboard');

        // Baptisms
        Route::resource('baptisms', \App\Http\Controllers\Leader\BaptismController::class)->only(['index','create','store']);
        // Members
        Route::resource('members', \App\Http\Controllers\Leader\MemberController::class);
    });

require __DIR__.'/auth.php';