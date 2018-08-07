<?php

use Illuminate\Database\Seeder;
use App\Service;
use App\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Service::class, 30)->create();
        factory(Product::class, 30)->create();
    }
}
