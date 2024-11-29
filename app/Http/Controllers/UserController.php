<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use UserTrait;

    public function index()
    {
        $Fadly_user = User::all();
        return view('user.index', [
            'user' => $Fadly_user
        ]);
    }

    public function verify($Fadly_id)
    {
        $Fadly_user = User::findOrFail($Fadly_id);
        $Fadly_user->verified = 1;
        $Fadly_user->email_verified_at = now();
        $Fadly_user->save();

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('memverifikasi user baru', [
                'UserID' => $Fadly_user->UserID,
                'Username' => $Fadly_user->Username,
                'NamaLengkap' => $Fadly_user->NamaLengkap,
                'Email' => $Fadly_user->Email,
                'Alamat' => $Fadly_user->Alamat,
                'roles' => $Fadly_user->roles,
            ]);
        }

        return redirect()->route('user.index');
    }


    public function store(Request $Fadly_request)
    {
        $Fadly_validate = $Fadly_request->validate([
            'Username' => 'required|string|min:3|unique:users,Username',
            'NamaLengkap' => 'required|string|min:3',
            'Email' => 'required|email|unique:users,Email',
            'Password' => 'required|string|min:8|confirmed',
            'Alamat' => 'required',
            'roles' => 'required',
        ]);


        $Fadly_user = User::create([
            'Username' => $Fadly_validate['Username'],
            'Password' => Hash::make($Fadly_validate['Password']),
            'NamaLengkap' => $Fadly_validate['NamaLengkap'],
            'Email' => $Fadly_validate['Email'],
            'Alamat' => $Fadly_validate['Alamat'],
            'roles' => $Fadly_validate['roles'],
            'verified' => 1,
        ]);

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('menambah user baru', [
                'UserID' => $Fadly_user->UserID,
                'Username' => $Fadly_user->Username,
                'NamaLengkap' => $Fadly_user->NamaLengkap,
                'Email' => $Fadly_user->Email,
                'Alamat' => $Fadly_user->Alamat,
                'roles' => $Fadly_user->roles,
            ]);
        }

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function create()
    {
        return view('user.create');
    }

    public function update(Request $Fadly_request, User $Fadly_user)
    {
        $Fadly_rules = [
            'Username' => [
                'required',
                'string',
                'min:3',
                Rule::unique('users', 'Username')->ignore($Fadly_user->UserID, 'UserID')
            ],
            'NamaLengkap' => 'required|string|min:3',
            'Alamat' => 'required',
            'roles' => 'required'
        ];

        if ($Fadly_request->filled('Password')) {
            $Fadly_rules['Password'] = 'required|string|min:8|confirmed';
        }


        $Fadly_validate = $Fadly_request->validate($Fadly_rules);

        $Fadly_dataToUpdate = [
            'Username' => $Fadly_validate['Username'],
            'NamaLengkap' => $Fadly_validate['NamaLengkap'],
            'Alamat' => $Fadly_validate['Alamat'],
            'roles' => $Fadly_validate['roles'],
            'Email' => $Fadly_user->Email
        ];


        if ($Fadly_request->filled('Password')) {
            $Fadly_dataToUpdate['Password'] = bcrypt($Fadly_validate['Password']);
        }

        $Fadly_originalData = $Fadly_user->getOriginal();

        $Fadly_user->update($Fadly_dataToUpdate);

        if(!Auth::user()->isAdmin()){
            $this->logActivity('mengupdate user', [
                'UserID' => $Fadly_user->UserID,
                'Username' => $Fadly_user->Username,
                'NamaLengkap' => $Fadly_user->NamaLengkap,
                'Email' => $Fadly_user->Email,
                'Alamat' => $Fadly_user->Alamat,
                'roles' => $Fadly_user->roles,
            ]);
        }

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
    }

    public function edit(User $Fadly_id)
    {
        return view('user.edit', [
            'user' => $Fadly_id
        ]);
    }

    public function destroy($Fadly_id)
    {
        $Fadly_user = User::findOrFail($Fadly_id);

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('menghapus user', [
                'UserID' => $Fadly_user->UserID,
                'Username' => $Fadly_user->Username,
                'NamaLengkap' => $Fadly_user->NamaLengkap,
                'Email' => $Fadly_user->Email,
                'Alamat' => $Fadly_user->Alamat,
                'roles' => $Fadly_user->roles,
            ]);
        }

        if ($Fadly_user->roles === 'peminjam') {
            $Fadly_user->forceDelete();
        } else {
            $Fadly_user->delete();
        }


        return redirect()->back()->with('success', 'User has been deleted successfully.');
    }

}
