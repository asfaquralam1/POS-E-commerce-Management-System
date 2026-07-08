<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeMailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index()
    {
        return view('site.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        return back()->withErrors([
            'verify' => 'These credentials do not match',
        ])->withInput($request->only('email')); // Preserve email in the input
    }

    public function register_view()
    {
        return view('site.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'phone' => ['required', 'regex:/^(?:\+8801[3-9]\d{8}|01[3-9]\d{8})$/'],
            'password' => 'required|string|min:4|confirmed',  // "confirmed" automatically checks password_confirmation
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($validator) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

           SendWelcomeMailJob::dispatch($user);

            //session()->flash('success','You Have Register successfully');
            return redirect('login')->with('success', 'You Have Register successfully');
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);
        return redirect()->intended('/');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otpCode = rand(100000, 999999);
        $email = $request->email;

        Otp::updateOrCreate(
            ['identifier' => $email],
            ['otp' => $otpCode, 'expires_at' => Carbon::now()->addMinutes(5)]
        );

        // Send email using SendGrid
        Mail::raw("Your OTP is: $otpCode", function ($message) use ($email) {
            $message->to($email)->subject('Your OTP Code');
        });

        return redirect()->route('otp.verify.form')->with('email', $email);
    }
    public function verifyForm()
    {
        return view('site.auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $key = 'verify-otp:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['otp' => 'Too many attempts. Try again later.']);
        }

        RateLimiter::hit($key, 60); // 60 seconds

        $otp = Otp::where('identifier', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        $user = User::firstOrCreate(['email' => $request->email]);

        Auth::login($user);
        $otp->delete();
        RateLimiter::clear($key);

        return redirect()->route('home');
    }


    public function forgotpass()
    {
        return view('site.auth.change_password');
    }

    public  function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }
}
