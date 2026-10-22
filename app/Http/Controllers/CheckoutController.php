<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    /**
     * 会計対象の卓一覧画面を表示
     */
    public function index()
    {
        $activeTables = Table::whereHas('orders', function ($query) {
            $query->where('status', '!=', 'paid');
        })->with(['orders' => function ($query) {
            $query->where('status', '!=', 'paid')->with('items.menu');
        }])->get();

        foreach ($activeTables as $table) {
            $tableTotal = 0;
            foreach ($table->orders as $order) {
                foreach ($order->items as $item) {
                    $price = $item->menu->price ?? 0;
                    $tableTotal += $price * $item->quantity;
                }
            }
            $table->total_amount = $tableTotal;
        }

        // Inertia::render で Vue コンポーネントへデータを渡す
        return Inertia::render('Checkout/Index', [
            'activeTables' => $activeTables
        ]);
    }

    /**
     * 指定された卓の会計詳細画面を表示
     */
    public function show($table_id)
    {
        $table = Table::findOrFail($table_id);

        $orders = Order::with('items.menu')
            ->where('table_id', $table_id)
            ->where('status', '!=', 'paid')
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('checkout.index')->with('message', '対象の卓に未会計の注文はありません。');
        }

        $summary = [];
        $totalAmount = 0;

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $itemName = $item->menu->name ?? '不明な商品';
                $price = $item->menu->price ?? 0;
                $quantity = $item->quantity;
                $subtotal = $price * $quantity;

                if (!isset($summary[$itemName])) {
                    $summary[$itemName] = [
                        'price' => $price,
                        'quantity' => 0,
                        'subtotal' => 0,
                    ];
                }

                $summary[$itemName]['quantity'] += $quantity;
                $summary[$itemName]['subtotal'] += $subtotal;
                $totalAmount += $subtotal;
            }
        }

        return Inertia::render('Checkout/Show', [
            'table' => $table,
            'summary' => $summary,
            'totalAmount' => $totalAmount
        ]);
    }

    /**
     * 会計完了処理
     */
    public function pay($table_id)
    {
        Order::where('table_id', $table_id)
            ->where('status', '!=', 'paid')
            ->update(['status' => 'paid']);

        return redirect()->route('checkout.index')->with('success', "卓のお会計が完了しました。");
    }
}