<?php

use App\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [['image' => 'http://readerscorner.co/storage/sliders/April2020/DlmNaIqU9G2cztMEpFLy.jpg']];
        Banner::insert($banners);
    }
}
