<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(GoodsTableSeeder::class);
        //Model::reguard();
    }
}

class GoodsTableSeeder extends Seeder
{
    public function run()
    {
        App\Goods::truncate();
        factory(App\Goods::class, 20)->create();
    }
}
