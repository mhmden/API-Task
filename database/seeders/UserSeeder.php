<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([ // Basic User
            'username' => 'UserAdmin88',
            'email' => 'test@test.test',
            'email_verified_at' => now(),
            'password' => 'testtest',
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('user');

        User::factory()->count(10)->create();
    }
}
