<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = Table::first();
        $menus = Menu::all();

        // 卓データまたはメニューデータが存在しない場合はスキップ
        if (!$table || $menus->isEmpty()) {
            $this->command->info('卓データまたはメニューデータが存在しないため、シーダーの実行をスキップしました。');
            return;
        }

        // 過去3日分の注文データを作成
        for ($i = 0; $i < 3; $i++) {
            $date = Carbon::now()->subDays($i);

            // 1日あたり2〜3件の注文を作成
            for ($j = 0; $j < rand(2, 3); $j++) {
                $order = Order::create([
                    'table_id' => $table->id,
                    'status' => 'completed',
                    'total_price' => 0, // 後で計算して更新
                    'created_at' => $date->copy()->addHours(rand(9, 18)),
                    'updated_at' => $date,
                ]);

                $totalAmount = 0;

                // 注文ごとにランダムで1〜2種類のメニューを選択
                $selectedMenus = $menus->random(min(2, $menus->count()));

                foreach ($selectedMenus as $menu) {
                    $quantity = rand(1, 3);
                    $price = $menu->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => $menu->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->created_at,
                    ]);

                    $totalAmount += $price * $quantity;
                }

                // 注文の合計金額を更新
                $order->update(['total_price' => $totalAmount]);
            
        }
    }
}