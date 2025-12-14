<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OtpController extends Controller
{
    // Show OTP entry form
    public function showVerifyForm()
    {
        return view('auth.verify-otp');
    }

    // Verify OTP
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);
        $otp = OtpCode::where('user_id', Auth::id())
                      ->where('code', $request->code)
                      ->where('expires_at', '>', Carbon::now())
                      ->first();

        if (! $otp) {
            return back()->withErrors(['code' => 'Invalid or expired OTP']);
        }
// dd($otp);
        // Mark phone as verified
        Auth::user()->update([
            'phone_verified_at' => Carbon::now(),
        ]);

        // Delete OTP after successful verification
        $otp->delete();

        return redirect()->route('dashboard')->with('success', 'Phone number verified!');
    }
}