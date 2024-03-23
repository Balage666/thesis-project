<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Helpers\Shared\OrderStatus;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Emsifa\RandomImage\RandomImage;
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

        \App\Models\User::create([
            'name' => 'Just Moderator',
            'email' => 'just.moderator@bluevenue.tp',
            'email_verified_at' => now(),
            'password' => Hash::make('moderator'),
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name=Just+Moderator",
            'remember_token' => Str::random(10),
        ])->Roles()->saveMany([
            \App\Models\UserRole::newModelInstance([
                'name' => 'Customer'
            ]),
            \App\Models\UserRole::newModelInstance([
                'name' => 'Moderator'
            ]),
        ]);

        \App\Models\User::create([
            'name' => 'Sal Lair Moadherathor',
            'email' => 'sal.lair.moadherathor@bluevenue.tp',
            'email_verified_at' => now(),
            'password' => Hash::make('moderator'),
            'profile_picture' => "https://ui-avatars.com/api/?size=256&background=random&name=Sal+Lair+Moadherathor",
            'remember_token' => Str::random(10),
        ])->Roles()->saveMany([
            \App\Models\UserRole::newModelInstance([
                'name' => 'Customer'
            ]),
            \App\Models\UserRole::newModelInstance([
                'name' => 'Seller'
            ]),
            \App\Models\UserRole::newModelInstance([
                'name' => 'Moderator'
            ]),
        ]);

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
                'user_id' => User::whereHas('Roles', function($query) {
                    $query->where('name', '=', 'Seller');
                })->inRandomOrder()->first()->id
            ]);
        }

        \App\Models\Category::factory(10)->create();

        \App\Models\Product::factory(20)->create()->each(function ($product) {

            \App\Models\User::all()->each(function ($user) use($product) {

                if ($user->id != $product->Distributor->id) {
                    $product->Ratings()->save(
                        \App\Models\ProductRating::newModelInstance([
                            'rating' => fake()->numberBetween(1, 5),
                            'rater' => $user->id
                        ])
                    );
                }

            });

            for ($i=0; $i < 5; $i++) {
                $product->Pictures()->save(
                    \App\Models\ProductPicture::newModelInstance([
                        'product_picture' => fake()->imageUrl(256, 256, $product->Category->name, true, $product->name, false, 'jpg')
                    ])
                );
            }

            $product->Comments()->save(
                \App\Models\ProductComment::newModelInstance([
                    'comment' => fake()->sentence(),
                    'commenter_id' => User::inRandomOrder()->first()->id
                ])
            );

        });


        \App\Models\Order::factory(30)->create()->each(function ($order) {

            \App\Models\Product::all()->each(function ($product) use($order) {

                if ($product->Distributor->id != $order->Customer->id) {
                    $generateAmount = fake()->numberBetween(1,10);
                    $order->OrderItems()->save(
                        \App\Models\OrderItem::newModelInstance([
                            'product_id' => $product->id,
                            'amount' => $generateAmount,
                            'price' => $product->price * $generateAmount
                        ])
                    );
                }

            });

        });

    }
}
