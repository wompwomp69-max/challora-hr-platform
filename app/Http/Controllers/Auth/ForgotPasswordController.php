<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            // Don't reveal whether the email exists
            return back()->with('status', 'If that email is registered, you will receive a reset link shortly.');
        }

        $token = \Illuminate\Support\Str::random(60);
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => \Hash::make($token), 'created_at' => now()]
        );

        $resetLink = route('password.reset', ['token' => $token, 'email' => $user->email]);

        \Illuminate\Support\Facades\Mail::send(
            'emails.password-reset',
            ['user' => $user, 'resetLink' => $resetLink],
            function ($msg) use ($user) {
                $msg->to($user->email)
                    ->subject('Reset Your Challora Password');
            }
        );

        return back()->with('status', 'If that email is registered, you will receive a reset link shortly.');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $record = \DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !\Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'This password reset token is invalid.']);
        }

        // Check token hasn't expired (60 minutes)
        if (\Carbon\Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'This password reset link has expired. Please request a new one.']);
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = \Hash::make($request->password);
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('flash_toast', ['message' => 'Password reset successfully. Please sign in.']);
    }
}
