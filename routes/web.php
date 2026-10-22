<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// トップページ（ウェルカム画面）
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ------------------------------------------------------------------------
// 卓上端末用ルーティング（一般ユーザー用・ログイン不要）
// ------------------------------------------------------------------------
Route::get('/table/{table}', [OrderController::class, 'index'])->name('table.show');
Route::post('/table/{table}/orders', [OrderController::class, 'store'])->name('order.store');

// 認証関連（auth.phpの読み込み）
require __DIR__.'/auth.php';

// ------------------------------------------------------------------------
// 管理画面・スタッフ用ルーティング（要ログイン）
// ------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // ダッシュボード
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('admin.dashboard');

    // プロフィール管理
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 厨房モニター（スタッフも利用可能）
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::patch('/kitchen/orders/{order}/status', [KitchenController::class, 'updateStatus'])->name('kitchen.orders.updateStatus');

    // 会計画面（スタッフも利用可能）
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/{table}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{table}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');


    // --------------------------------------------------------------------
    // 管理者専用ルートグループ（要ログイン ＋ 管理者権限）
    // --------------------------------------------------------------------
    Route::middleware(['admin'])->group(function () {

        // メニュー管理
        Route::get('admin/menus/index', [MenuController::class, 'index'])->name('admin.menus.index');
        Route::get('admin/menus/create', [MenuController::class, 'create'])->name('admin.menus.create');
        Route::post('admin/menus', [MenuController::class, 'store'])->name('admin.menus.store');
        Route::get('admin/menus/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menus.edit');
        Route::put('admin/menus/{menu}', [MenuController::class, 'update'])->name('admin.menus.update');
        Route::delete('admin/menus/{menu}', [MenuController::class, 'destroy'])->name('admin.menus.destroy');
        
        // 売上集計
        Route::get('admin/sales/index', [SalesController::class, 'index'])->name('admin.sales.index');

        // ユーザー管理
        Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    });
});
