<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * メニュー一覧表示
     */
    public function index()
    {
        // 登録日の新しいい順に取得（ページネーション付き）
        $menus = Menu::orderBy('id', 'desc')->paginate(10);

        // view('admin.menus.index') から Inertia::render に変更
        return Inertia::render('Admin/Menus/Index', [
            'menus' => $menus,
            'flash' => [
                'success' => session('success'),
            ],
        ]);
    }

    /**
     * 新規登録フォーム表示
     */
    public function create()
    {
        // view() から Inertia::render() に変更
        return Inertia::render('Admin/Menus/Create');
    }

    /**
     * 新規保存処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          =>  'required|string|max:255',
            'price'         =>  'required|integer|min:0',
            'category'      =>  'required|string',
            'description'   =>  'nullable|string',
            'is_available'   =>  'boolean',
        ]);

        Menu::create($validated);

        return Redirect()->route('admin.menus.index')
            ->with('success','メニューを追加しました。');
    }

    /**
     * 詳細表示（今回は一覧で足りるため一覧へリダイレクト）
     */
    public function show(Menu $menu)
    {
        return redirect()->route('admin.menus.index');
    }

    /**
     * 編集フォーム表示
     */
    public function edit(Menu $menu)
    {
        return Inertia::render('Admin/Menus/Edit', [
            'menu' => $menu,
        ]);
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|integer|min:0',
            'category'      => 'required|string',
            'description'   => 'nullable|string',
            'is_available'  => 'boolean',
        ]);

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'メニューを更新しました。');
    }

    /**
     * 削除処理
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'メニューを削除しました。');
    }
}
