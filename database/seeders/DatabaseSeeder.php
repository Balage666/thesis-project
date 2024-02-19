<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\Shared\SeederHelper;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userSeed = SeederHelper::USER_SEED;
        $adminSeed = SeederHelper::ADMIN_SEED_VALUE;

        \App\Models\User::factory($userSeed)->create();
        \App\Models\UserRole::factory()->create([
            'name' => 'Customer',
            'user_id' => 1
        ]);
        \App\Models\UserRole::factory()->create([
            'name' => 'Seller',
            'user_id' => 1
        ]);
        // \App\Models\Phone::factory()->create([
        //     'number' => '0623400400',
        //     'mask' => '(## ##) ### ####',
        //     'user_id' => 1
        // ]);

        \App\Models\User::factory()->create([
            'id' => $adminSeed,
            'name' => 'Admin Istrator',
            'email' => 'admin@bluevenue.tp',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name=Admin+Istrator",
            'remember_token' => Str::random(10),
        ]);
        \App\Models\UserRole::factory()->create([
            'name' => 'Customer',
            'user_id' => $adminSeed
        ]);
        \App\Models\UserRole::factory()->create([
            'name' => 'Seller',
            'user_id' => $adminSeed
        ]);
        \App\Models\UserRole::factory()->create([
            'name' => 'Moderator',
            'user_id' => $adminSeed
        ]);
        \App\Models\UserRole::factory()->create([
            'name' => 'Admin',
            'user_id' => $adminSeed
        ]);
    }
}
