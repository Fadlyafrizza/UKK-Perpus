<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Fadly_user = User::create([
            'Username' => 'Admin',
            'Password' => bcrypt('password'),
            'Email' => 'admin@gmail.com',
            'verified' => true,
            'email_verified_at' => now()
        ]);

        $Fadly_petugas = User::create([
            'Username' => 'Petugas',
            'Password' => bcrypt('password'),
            'Email' => 'petugas@gmail.com',
            'verified' => true,
            'email_verified_at' => now()
        ]);

        $Fadly_peminjam = User::create([
            'Username' => 'Peminjam',
            'Password' => bcrypt('password'),
            'Email' => 'peminjam@gmail.com',
            'verified' => true,
            'email_verified_at' => now()
        ]);

        $Fadly_role = Role::create([
            'name' =>  'administrator',
        ]);

        $Fadly_userRole = Role::create([
            'name' => 'peminjam',
        ]);

        $Fadly_petugasRole = Role::create([
            'name' => 'petugas',
        ]);

        $Fadly_user->roles()->attach($Fadly_role->id);

        $Fadly_user->update(['roles' => 'administrator']);

        $Fadly_petugas->roles()->attach($Fadly_petugasRole->id);

        $Fadly_petugas->update(['roles' => 'petugas']);

        $Fadly_peminjam->roles()->attach($Fadly_peminjam->id);

    }
}
