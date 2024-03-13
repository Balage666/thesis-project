<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\Shared\SeederHelper;
use Emsifa\RandomImage\RandomImage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userSeed = SeederHelper::USER_SEED;
        $adminSeed = SeederHelper::ADMIN_SEED_VALUE;
        $provider = new \Emsifa\RandomImage\Providers\UnsplashProvider();
        $categories = SeederHelper::BASE_CATEGORIES;

        \App\Models\User::factory($userSeed)->create()->each(function($user) {
            if($user->id % 2 == 0) {
                $user->Roles()->saveMany([
                    \App\Models\UserRole::newModelInstance([
                        'name' => 'Customer'
                    ]),
                    \App\Models\UserRole::newModelInstance([
                        'name' => 'Seller'
                    ]),
                    // \App\Models\UserRole::create([
                    //     'name' => 'Customer',
                    //     'user_id' => $user->id
                    // ]),
                    // \App\Models\UserRole::create([
                    //     'name' => 'Seller',
                    //     'user_id' => $user->id
                    // ])
                ]);
            }
            else {
                $user->Roles()->save(

                    \App\Models\UserRole::newModelInstance([
                        'name' => 'Customer',
                    ])
                );
            }

        });

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
            \App\Models\UserRole::newModelInstance([
                'name' => 'Customer',
            ]),
            \App\Models\UserRole::newModelInstance([
                'name' => 'Seller',
            ]),
            \App\Models\UserRole::newModelInstance([
                'name' => 'Moderator',
            ]),
            \App\Models\UserRole::newModelInstance([
                'name' => 'Admin',
            ])
        ]);

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category
            ]);
        }
        \App\Models\Product::factory(20)->create()->each(function ($product) {

            $product->Pictures()->save(
                \App\Models\ProductPicture::newModelInstance([
                    'product_picture' => fake()->imageUrl(256, 256, $product->Category->name, true, $product->name, false, 'jpg')
                ])
            );

        });

        // \App\Models\Product::factory(20)->create()->each(function ($product) use ($provider) {

        //     $product->Pictures()->save(\App\Models\ProductPicture::create([
        //         'product_picture' => RandomImage::make(256, 256, "$product->name", $provider)->url(),
        //         'product_id' => $product->id
        //     ]));

        // }

    }
}
