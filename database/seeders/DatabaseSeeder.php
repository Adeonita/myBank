<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Database\Factories\ShopkeeperFactory;
// use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new UserFactory();
        $shopkeeper = new ShopkeeperFactory();

        $user
            ->count(2)
            ->hasWallet(1)
            ->create();

        $shopkeeper
            ->count(1)
            ->create();
    }
}
