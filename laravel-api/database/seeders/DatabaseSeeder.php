<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        /*************************************************** MODULES ************************************************** */
        $modules = [
            ['id' => 1, 'name' => 'product'],
            ['id' => 2, 'name' => 'category'],
            ['id' => 3, 'name' => 'brand'],
            ['id' => 4, 'name' => 'tax'],
            ['id' => 5, 'name' => 'unit'],
            ['id' => 6, 'name' => 'supplier'],
            ['id' => 7, 'name' => 'customer'],
            ['id' => 8, 'name' => 'user'],
            ['id' => 9, 'name' => 'warehouse'],
            ['id' => 10, 'name' => 'role'],
            ['id' => 11, 'name' => 'pos'],
            ['id' => 12, 'name' => 'type'],
            ['id' => 13, 'name' => 'symbology'],
            ['id' => 14, 'name' => 'label'],
            ['id' => 15, 'name' => 'stock_adjustment'],
            ['id' => 16, 'name' => 'customer_group'],
            ['id' => 17, 'name' => 'common'],
            ['id' => 18, 'name' => 'purchase'],
            ['id' => 19, 'name' => 'purchase_return'],
        ];
        /*************************************************** ROLES ************************************************** */
        $roles = [
            ['id' => 1, 'name' => 'Super Admin', 'description' => 'Super admin can do anything, can even delete this world !', 'limit' => 1, 'is_locked' => 1],
            ['id' => 2, 'name' => 'Admin', 'description' => 'All rights or actions allowed !', 'limit' => 2, 'is_locked' => 1],
            ['id' => 3, 'name' => 'Seller', 'description' => 'Rights for selling products !', 'limit' => 3],
            ['id' => 4, 'name' => 'Purchaser', 'description' => 'Rights or purchase products !', 'limit' => 4],
        ];
        /*************************************************** STATUSES ************************************************** */
        $statuses = [
            ['id' => 1, 'name' => 'online', 'online_status' => 1],
            ['id' => 2, 'name' => 'offline', 'online_status' => 1],
            ['id' => 3, 'name' => 'active', 'role_status' => 1, 'user_status' => 1],
            ['id' => 4, 'name' => 'inactive', 'role_status' => 1, 'user_status' => 1],
            ['id' => 5, 'name' => 'pending', 'role_status' => 1, 'user_status' => 1, 'purchase_status' => 1, 'purchase_return_status' => 1],
            ['id' => 6, 'name' => 'paid', 'payment_status' => 1],
            ['id' => 7, 'name' => 'unpaid', 'payment_status' => 1],
            ['id' => 8, 'name' => 'ordered', 'order_status' => 1, 'purchase_status' => 1],
            ['id' => 9, 'name' => 'packed', 'order_status' => 1],
            ['id' => 10, 'name' => 'shipped', 'order_status' => 1],
            ['id' => 11, 'name' => 'returned', 'order_status' => 1, 'pos_sale_status' => 1, 'purchase_return_status' => 1],
            ['id' => 12, 'name' => 'partially paid', 'payment_status' => 1],
            ['id' => 13, 'name' => 'expired'],
            ['id' => 14, 'name' => 'away', 'online_status' => 1],
            ['id' => 15, 'name' => 'blocked', 'user_status' => 1],
            ['id' => 16, 'name' => 'open', 'warehouse_status' => 1],
            ['id' => 17, 'name' => 'closed', 'warehouse_status' => 1],
            ['id' => 18, 'name' => 'permanently closed', 'warehouse_status' => 1],
            ['id' => 19, 'name' => 'temperorily closed', 'warehouse_status' => 1],
            ['id' => 20, 'name' => 'completed', 'pos_sale_status' => 1],
            ['id' => 21, 'name' => 'due', 'payment_status' => 1],
            ['id' => 22, 'name' => 'recieved ✓', 'purchase_status' => 1],
        ];
        /*************************************************** COUNTRIES ************************************************** */
        $countries = [
            ['id' => 1, 'code' => 'IN', 'name' => 'India'],
        ];
        /************************************************************************************************************* */
        /*collect($modules)->each(function ($data) {\App\Models\Module::create($data);});
        collect($roles)->each(function ($data) {\App\Models\Role::create($data);});
        collect($statuses)->each(function ($data) {\App\Models\Status::create($data);});*/
        collect($countries)->each(function ($data) {\App\Models\Country::create($data);});
    }
}
