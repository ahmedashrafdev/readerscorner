<?php

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
        $this->call(BannerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(AgeSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(ProductKeySeeder::class);
        $this->call(ProductSeeder::class);

    }
}
