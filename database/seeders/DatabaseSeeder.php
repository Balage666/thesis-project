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

        \App\Models\User::factory($userSeed)->create()->each(function($user) {
            $user->Roles()->save(\App\Models\UserRole::create([
                'name' => 'Customer',
                'user_id' => $user->id
            ]));
        });
        // \App\Models\Phone::factory()->create([
        //     'number' => '0623400400',
        //     'mask' => '(## ##) ### ####',
        //     'user_id' => 1
        // ]);

        $admin = \App\Models\User::create([
            'id' => $adminSeed,
            'name' => 'Admin Istrator',
            'email' => 'admin@bluevenue.tp',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name=Admin+Istrator",
            'remember_token' => Str::random(10),
        ]);
        $admin->Roles()->saveMany([
            \App\Models\UserRole::create([
                'name' => 'Customer',
                'user_id' => $admin->id
            ]),
            \App\Models\UserRole::create([
                'name' => 'Seller',
                'user_id' => $admin->id
            ]),
            \App\Models\UserRole::create([
                'name' => 'Moderator',
                'user_id' => $admin->id
            ]),
            \App\Models\UserRole::create([
                'name' => 'Admin',
                'user_id' => $admin->id
            ])
        ]);
    }
}
