<?php

namespace App\Http\Controllers;

use App\Traits\UserTrait;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\RolesUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'Alamat' => $Fadly_request->Alamat
        ]);

        $Fadly_user->assignRole(RolesUser::USER);

        return redirect()->route('home');
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
