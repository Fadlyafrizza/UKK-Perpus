<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\RolesUser;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use UserTrait;

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $Fadly_request)
    {
        $Fadly_credentials = $Fadly_request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($Fadly_credentials)) {
            $Fadly_user = Auth::user();

            if ($Fadly_user->verified == 0) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum diverifikasi.',
                ])->onlyInput('email');
            }

            $Fadly_request->session()->regenerate();

            if (!Auth::user()->isAdmin()) {
                $this->logActivity('petugas login', [
                    'Username' => Auth::user()->Username,
                    'Login' => Carbon::now()
                ]);
            }

            if ($Fadly_user->roles()->where('name', 'administrator')->exists()) {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->intended('/');
            }
        } else {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $Fadly_request)
    {
        $Fadly_validator = Validator::make($Fadly_request->all(), [
            'username' => 'required|string|max:255|unique:users,Username',
            'NamaLengkap' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,Email',
            'password' => 'required|string|min:8|confirmed',
            'Alamat' => 'required'
        ]);

        if ($Fadly_validator->fails()) {
            return back()
                ->withErrors($Fadly_validator)
                ->withInput();
        }

        $Fadly_user = User::create([
            'Username' => $Fadly_request->username,
            'Email' => $Fadly_request->email,
            'Password' => Hash::make($Fadly_request->password),
            'NamaLengkap' => $Fadly_request->NamaLengkap,
            'Alamat' => $Fadly_request->Alamat,
            'verified' => 0
        ]);

        $Fadly_user->assignRole(RolesUser::USER);

        Auth::login($Fadly_user);

        $data = $this->generateOTP();
        $this->sendOTP($Fadly_user, $data);

        return redirect()->route('verification.verify')
            ->with('message', 'Silakan cek email Anda untuk kode verifikasi.');
    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        return view('email.verify', compact('user'));
    }

    protected function generateOTP()
    {
        return str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function verifyOTP(Request $Fadly_request)
    {
        $Fadly_request->validate([
            'otp' => 'required|string|size:4',
        ]);

        $Fadly_user = Auth::user();
        $Fadly_cacheKey = 'otp_' . $Fadly_user->id;
        $Fadly_storedOTP = Cache::get($Fadly_cacheKey);

        if (!$Fadly_storedOTP || $Fadly_storedOTP !== $Fadly_request->otp) {
            return back()->withErrors([
                'otp' => 'Kode verifikasi tidak valid atau sudah kadaluarsa.'
            ]);
        }

        Cache::forget($Fadly_cacheKey);

        $Fadly_user->update(['verified' => 1]);

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function resendOTP(Request $Fadly_request)
    {
        $Fadly_user = Auth::user();
        $data = $this->generateOTP();
        $this->sendOTP($Fadly_user, $data);

        return back()->with('message', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    public function sendOTP($user, $otp)
    {
        $cacheKey = 'otp_' . $user->id;
        Cache::put($cacheKey, $otp, now()->addMinutes(15));

        Mail::to($user->Email)->send(new NotificationMail([
            'subject' => 'Kode Verifikasi Email',
            'code' => "Kode verifikasi Anda adalah: $otp\nKode ini akan kadaluarsa dalam 15 menit."
        ]));
    }

    public function logout(Request $Fadly_request)
    {
        if (!Auth::user()->isAdmin()) {
            $this->logActivity('petugas logout', [
                'Username' => Auth::user()->Username,
                'Logout' => Carbon::now()
            ]);
        }

        Auth::logout();
        $Fadly_request->session()->invalidate();
        $Fadly_request->session()->regenerateToken();

        return redirect('/');
    }
}
