<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DeliveryBoy;
use App\Models\Manager;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductItem;
use App\Models\ProductItemFeature;
use App\Models\Shop;
use App\Models\ShopCoupon;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => "Admin",
                'email' => "admin@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'admin_avatars/1.jpeg'
            ]
        ];

        $users = [
            [
                'name' => "User 1",// William Clark
                'email' => "user@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'user_avatars/1.jpeg',
                'mobile'=>"+918469435337",
                "mobile_verified"=>true
            ],
            [
                'avatar_url' => 'user_avatars/2.jpeg',
                'name' => "User 2", // James Perez
                'email' => "user2@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'mobile'=>"+918469435336",
                "mobile_verified"=>true
            ],
            [
                'name' => "User 3",// Olivia Austin
                'email' => "user3@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'user_avatars/3.jpeg',
                'mobile'=>"+918469435335",
                "mobile_verified"=>true
            ],
            [
                'name' => "User 4",// Hannah Wilson
                'email' => "user4@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'user_avatars/4.jpeg',
                'mobile'=>"+918469435334",
                "mobile_verified"=>true
            ],
            [
                'name' => "User 5",// Henry Martin
                'email' => "user5@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'user_avatars/5.jpeg',

            ],

        ];

        $deliveryBoys = [
            [
                'name' => "Delivery Boy 1",// Charles Jones
                'email' => "delivery.boy@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'delivery_boy_avatars/1.jpeg',
                'latitude' => 37.421104,
                'longitude' => -122.086951,
                'mobile'=>"+918469435337",
                "mobile_verified"=>true
            ],
            [
                'name' => "Delivery Boy 2",// David Miller
                'email' => "delivery.boy2@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'delivery_boy_avatars/2.jpeg',
                'mobile'=>"+918469435336",
                "mobile_verified"=>true,
                'latitude' => 37.419010,
                'longitude' => -122.077957,
            ],
            [
                'name' => "Delivery Boy 3",// John Taylor
                'email' => "delivery.boy3@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'delivery_boy_avatars/3.jpg',
                'mobile'=>"+918469435335",
                "mobile_verified"=>true,
                'latitude' => 37.416797,
                'longitude' => -122.082967,
            ],
            [
                'name' => "Delivery Boy 4",// Benjamin Lopez
                'email' => "delivery.boy4@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'delivery_boy_avatars/4.jpg',
                'mobile'=>"+918469435334",
                "mobile_verified"=>true,
                'latitude' => 37.415458,
                'longitude' => -122.074953,
            ],
            [
                'name' => "Delivery Boy 5",// Alexander Ray
                'email' => "delivery.boy5@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'delivery_boy_avatars/5.jpg',

                'latitude' => 37.421617,
                'longitude' => -122.096288,
            ],
        ];

        $managers = [
            [
                'name' => "Manager 1", // Michael Smith
                'email' => "manager@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'manager_avatars/1.jpeg',
                'mobile'=>"+918469435337",
                "mobile_verified"=>true
            ],
            [
                'name' => "Manager 2",// Nicholas Jones
                'email' => "manager2@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'manager_avatars/2.jpeg',
                'mobile'=>"+918469435336",
                "mobile_verified"=>true
            ],
            [
                'name' => "Manager 3",// Ryan corner
                'email' => "manager3@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'manager_avatars/3.jpeg',
                'mobile'=>"+918469435335",
                "mobile_verified"=>true
            ],
            [
                'name' => "Manager 4",// Miles White
                'email' => "manager4@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'manager_avatars/4.jpeg',
                'mobile'=>"+918469435334",
                "mobile_verified"=>true
            ],
            [
                'name' => "Manager 5",// Dylan Parker
                'email' => "manager5@demo.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'avatar_url' => 'manager_avatars/5.jpeg',

            ],
        ];

        $categories = [
            [
                'title' => 'Water',
                'commesion' => 0.3,
                'image_url' => "category_images/cloth.png",
            ],
            [
                'title' => 'Gas',
                'commesion' => 0.7,
                'image_url' => "category_images/grocery.png",
            ],

        ];

        $subCategories = [
            [
                'title' => 'New',
                'price' => 0.5,
                'category_id' => "1",
            ],
            [
                'title' => 'change',
                'price' => 0.3,
                'category_id' => "1",
            ],
            [
                'title' => 'New',
                'price' =>5,
                'category_id' => "2",
            ],
            [
                'title' => 'change',
                'price' => 35,
                'category_id' => "2",
            ],

        ];


        $coupons = [
            [
                'code' => 'SAVE40',
                'description' => '40% off at any products with product price above $300 and get upto $800 discount',
                'offer' => 40,
                'min_order' => 300,
                'max_discount' => 800,
                'for_new_user' => true,
                'for_only_one_time' => true,
                'expired_at' => now()->addDays(2),
            ],
            [
                'code' => 'GRUB10',
                'description' => 'Buy Product with above $50 and get 10% discount upto $200',
                'offer' => 10,
                'min_order' => 50,
                'max_discount' => 200,
                'expired_at' => now()->addDays(2)
            ],
            [
                'code' => 'FLAT25',
                'description' => 'Flat 25% off on any Order with total amount greater than $100',
                'offer' => 25,
                'min_order' => 100,
                'max_discount' => 800,
                'expired_at' => now()->addDays(2)
            ],
            [
                'code' => 'GET30',
                'description' => '30% off on any Order above $500 and win discount upto $300',
                'offer' => 30,
                'min_order' => 500,
                'max_discount' => 300,
                'expired_at' => now()->addDays(2)
            ],
            [
                'code' => 'SALE50',
                'description' => '50% off at any Order above $800. Buy using code SALE50 and get upto $500 discount',
                'offer' => 50,
                'min_order' => 800,
                'max_discount' => 500,
                'expired_at' => now()->addDays(2)
            ],
            [
                'code' => 'GET20',
                'description' => 'upto 20% off at any Order above $200',
                'offer' => 20,
                'min_order' => 200,
                'max_discount' => 200,
                'expired_at' => now()->addDays(2)
            ],
            [
                'code' => 'SAVE10',
                'description' => '10% off with toal amount $50 and above on any Prduct',
                'offer' => 10,
                'min_order' => 50,
                'max_discount' => 100,
                'expired_at' => now()->addDays(2)
            ],
            [
                'code' => 'FLAT15',
                'description' => 'Get Flat 15% off on your Order $50 and above upto $100 discount',
                'offer' => 15,
                'min_order' => 50,
                'max_discount' => 100,
                'expired_at' => now()->addDays(2)
            ],
        ];


        $shops = [
            [
                'name' => "Fashion Factory",// Fashion Factory
                'email' => "shop@demo.com",
                'mobile' => "789654123",
                'latitude' => 37.4235492,
                'longitude' => -122.0924447,
                'address' => "Garcia Ave, Mountain View",
                'image_url' => 'shop_images/1.jpg',
                'default_tax' => 10,
'barcode' => '145234',
                'available_for_delivery' => true,
                'open' => true,
                'manager_id' => 1,

                "delivery_range" => 99999999
            ],
            [
                'name' => "The Corner Store",// The Corner Store
                'email' => "shop2@demo.com",
                'mobile' => "147852369",
                'latitude' => 37.4258241,
                'longitude' => -122.0810562,
                'address' => "Bill Graham Pkwy, Mountain View",
                'image_url' => 'shop_images/2.jpg',
                'default_tax' => 15,
'barcode' => '145734',

                 'available_for_delivery' => true,
                'open' => true,
                'manager_id' => 2,

                "delivery_range" => 99999999
            ],

        ];



        $userAddresses = [
            [
                'latitude' => 37.4218855,
                'longitude' => -122.070862,
                'address' => 'A to Z Tree Nursery',
                'city' => 'Google Bay',
                'pincode' => 456789,
                'user_id' => 1
            ],
            [
                'latitude' => 37.4203822,
                'longitude' => -122.0804247,
                'address' => 'UPS Drop box',
                'city' => 'Charleston',
                'pincode' => 369852,
                'user_id' => 2
            ],
            [
                'latitude' => 37.4225616,
                'longitude' => -122.089441,
                'address' => 'Alza Vollyball Court',
                'city' => 'Googleplex',
                'pincode' => 147852,
                'user_id' => 3
            ],
            [
                'latitude' => 37.422330,
                'longitude' => -122.101335,
                'address' => 'San Antonio Rd',
                'city' => ' Palo Alto',
                'pincode' => 452033,
                'user_id' => 4
            ],
            [
                'latitude' => 37.416131,
                'longitude' => -122.092675,
                'address' => 'Rengstorff Ave',
                'city' => 'Mountain View',
                'pincode' => 240431,
                'user_id' => 5
            ],
        ];

        $shopCoupons = [
            [
                'shop_id' => 1,
                'coupon_id' => 1,
            ],
            [
                'shop_id' => 1,
                'coupon_id' => 2,
            ],
            [
                'shop_id' => 1,
                'coupon_id' => 3,
            ],
            [
                'shop_id' => 1,
                'coupon_id' => 4,
            ],

            [
                'shop_id' => 2,
                'coupon_id' => 1,
            ],
            [
                'shop_id' => 2,
                'coupon_id' => 2,
            ],
            [
                'shop_id' => 2,
                'coupon_id' => 3,
            ],




        ];


        foreach ($users as $user) {
            User::create($user);
        }
        foreach ($admins as $admin) {
            Admin::create($admin);
        }


        foreach ($managers as $manager) {
            Manager::create($manager);
        }
        foreach ($categories as $category) {
            Category::create($category);
        }
        foreach ($subCategories as $subCategory) {
            SubCategory::create($subCategory);
        }
        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }

        foreach ($shops as $shop) {
            Shop::create($shop);
        }

        foreach ($deliveryBoys as $deliveryBoy) {
            DeliveryBoy::create($deliveryBoy);
        }



        foreach ($userAddresses as $userAddress) {
            UserAddress::create($userAddress);
        }

        foreach ($shopCoupons as $shopCoupon) {
            ShopCoupon::create($shopCoupon);
        }


    }
}
