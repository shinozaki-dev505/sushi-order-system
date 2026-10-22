<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    /**
     * 注文画面の表示
     */
    public function index(Table $table)
    {
        // 提供可能なメニューを取得してカテゴリごとにグループ化
        $menus = Menu::where('is_available', true)->get()->groupBy('category');

        return view('orders.index', compact('table', 'menus'));
    }

    /**
     * 注文をDBに保存する処理（orders / order_items）
     */
    public function store(Request $request, Table $table)
    {
        // 1. リクエストバリデーション
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            // 2. トランザクション処理
            $order = DB::transaction(function () use ($request, $table) {
                
                // 注文ヘッダーの作成
                $order = Order::create([
                    'table_id' => $table->id,
                    'status' => 'pending',
                    'total_price' => 0,
                ]);

                $totalAmount = 0;

                // 注文詳細の作成と合計金額計算
                foreach ($request->items as $itemData) {
                    $menu = Menu::findOrFail($itemData['id']);
                    $itemTotal = $menu->price * $itemData['quantity'];
                    $totalAmount += $itemTotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id'  => $menu->id,
                        'quantity' => $itemData['quantity'],
                        'price'    => $menu->price,
                    ]);
                }

                // 合計金額の更新
                $order->update([
                    'total_price' => $totalAmount,
                ]);

                return $order;
            });

            // 3. 成功レスポンス
            return response()->json([
                'success' => true,
                'message' => 'ご注文を承りました！',
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Order Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => '注文処理中にエラーが発生しました。',
            ], 500);
        }
    }
}