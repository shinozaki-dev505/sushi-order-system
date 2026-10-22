<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // にぎり
            ['name' => 'まぐろ', 'price' => 150, 'category' => 'にぎり', 'description' => '新鮮なまぐろの赤身です。','image_url' => 'images/maguro.jpg'],
            ['name' => 'サーモン', 'price' => 150, 'category' => 'にぎり', 'image_url' => 'images/salmon.jpg'],
            ['name' => 'ハマチ', 'price' => 180, 'category' => 'にぎり', 'image_url' => 'images/hamachi.jpg'],
            ['name' => 'えび', 'price' => 120, 'category' => 'にぎり', 'image_url' => 'images/ebi.jpg'],
            ['name' => '玉子', 'price' => 100, 'category' => 'にぎり', 'image_url' => 'images/tamago.jpg'],

            // 軍艦・巻物
            ['name' => 'いくら', 'price' => 260, 'category' => '軍艦', 'image_url' => 'images/ikura.jpg'],
            ['name' => 'ネギトロ', 'price' => 150, 'category' => '軍艦', 'image_url' => 'images/negitoro.jpg'],
            ['name' => '鉄火巻', 'price' => 180, 'category' => '巻物', 'image_url' => 'images/tekkamaki.jpg'],

            // サイドメニュー・ドリンク
            ['name' => 'あさりの味噌汁', 'price' => 200, 'category' => 'サイド', 'image_url' => 'images/misoshiru.jpg'],
            ['name' => '生ビール', 'price' => 500, 'category' => 'ドリンク', 'image_url' => 'images/beer.jpg'],
        ];

        foreach ($menus as $menu) {
            DB::table('menus')->insert([
                'name' => $menu['name'],
                'price' => $menu['price'],
                'category' => $menu['category'],
                'description' => $menu['description'] ?? null,
                'image_url' => $menu['image_url'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}