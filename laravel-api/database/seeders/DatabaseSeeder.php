<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Module;
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
        /************************************************************************************************************* */
        collect($modules)->each(function ($data) {Module::create($data);});

    }
}
