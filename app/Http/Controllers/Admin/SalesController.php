<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SalesController extends Controller
{
    //
    public function index(){
        // 1. 日別売上集計
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total_sales' ),
            DB::raw('COUNT(*) as total_orders')
        )
        ->groupBy('date')
        ->orderBy('date','desc')
        ->get();

        // 2. 商品別売上集計
        $itemSales = OrderItem::select(
            'menu_id',
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('SUM(price * quantity) as total_sales')
        )
        ->with('menu')  //メニュー名を取得するため
        ->groupBy('menu_id')
        ->orderBy('total_sales','desc')
        ->get();

        // view('admin.sales.index') から Inertia::render に変更
        return Inertia::render('Admin/Sales/Index', [
            'dailySales' => $dailySales,
            'itemSales'  => $itemSales,
        ]);
    }
}
