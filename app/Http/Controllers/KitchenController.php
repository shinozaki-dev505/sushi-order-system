<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KitchenController extends Controller
{
    /**
     * 厨房モニター画面を表示
     */
    public function index()
    {
        // 提供完了（served）以外の注文（未調理 pending, 調理中 cooking, お届け中 delivering）を取得
        $orders = Order::with(['table', 'items.menu'])
            ->whereIn('status', ['pending', 'cooking', 'delivering'])
            ->orderBy('created_at', 'asc')
            ->get();

        return Inertia::render('Kitchen/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * 注文ステータスの更新処理
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,cooking,delivering,served',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back();
    }
}