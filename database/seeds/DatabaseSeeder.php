<?php

use App\Model\Brand;
use App\Model\Category;
use App\Model\Description;
use App\Model\Location;
use App\Model\Manufacture;
use App\Model\Product;
use App\Model\Transfer;
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
        // $this->call(UsersTableSeeder::class);
        factory(Brand::class,10)->create();
        factory(Category::class,10)->create();
        factory(Description::class,10)->create();
        factory(Location::class,10)->create();
        factory(Manufacture::class,10)->create();
        factory(Product::class,10)->create();
        factory(Transfer::class,10)->create();
    }
}
