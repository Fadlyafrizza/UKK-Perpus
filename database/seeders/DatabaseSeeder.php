<?php

namespace Database\Seeders;

use App\Models\Buku;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        Buku::factory(5)->create();

        $this->call([
            RoleSeeder::class,
        ]);
    }
}
