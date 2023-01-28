<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Role;

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
            ['name' => 'product'],
            ['name' => 'category'],
            ['name' => 'brand'],
            ['name' => 'tax'],
            ['name' => 'unit'],
            ['name' => 'supplier'],
            ['name' => 'customer'],
            ['name' => 'user'],
            ['name' => 'warehouse'],
            ['name' => 'role'],
            ['name' => 'pos'],
            ['name' => 'type'],
            ['name' => 'symbology'],
            ['name' => 'label'],
            ['name' => 'stock_adjustment'],
            ['name' => 'customer_group'],
            ['name' => 'common'],
            ['name' => 'purchase'],
            ['name' => 'purchase_return'],
        ];
        $roles = [
            ['name' => 'Super Admin', 'description' => 'Super admin can do anything, can even delete this world !', 'limit' => 1, 'is_locked' => 1],
            ['name' => 'Admin', 'description' => 'All rights or actions allowed !', 'limit' => 2, 'is_locked' => 1],
            ['name' => 'Seller', 'description' => 'Rights for selling products !', 'limit' => 3],
            ['name' => 'Purchaser', 'description' => 'Rights or purchase products !', 'limit' => 4],
        ];
        /************************************************************************************************************* */
        collect($modules)->each(function ($data) {Module::create($data);});
        collect($roles)->each(function ($data) {Role::create($data);});
    }
}
