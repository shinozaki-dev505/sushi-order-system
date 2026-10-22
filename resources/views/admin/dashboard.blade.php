<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('管理者ダッシュボード') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">寿司注文管理システム - 管理機能</h3>
                    <p class="mb-6 text-gray-600">管理者として正常にログインしました。以下の各機能へ直接アクセスできます。</p>

                    <!-- ショートカットボタン一覧 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                        <!-- 厨房画面へ -->
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <h4 class="font-bold text-gray-800 mb-2">厨房モニター</h4>
                            <p class="text-sm text-gray-600 mb-4">注文の受付状況や調理・お届けステータスを管理します。</p>
                            <a href="{{ route('kitchen.index') }}" class="inline-block bg-green-600 text-white text-center px-4 py-2 rounded hover:bg-green-700 w-full font-semibold">
                                厨房画面へ
                            </a>
                        </div>

                        <!-- 会計画面へ -->
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <h4 class="font-bold text-gray-800 mb-2">会計管理</h4>
                            <p class="text-sm text-gray-600 mb-4">各テーブルのご清算や伝票処理を行います。</p>
                            <a href="{{ route('checkout.index') }}" class="inline-block bg-emerald-600 text-white text-center px-4 py-2 rounded hover:bg-emerald-700 w-full font-semibold">
                                会計画面へ
                            </a>
                        </div>

                        <!-- メニュー管理へ -->
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <h4 class="font-bold text-gray-800 mb-2">メニュー管理</h4>
                            <p class="text-sm text-gray-600 mb-4">商品の登録・編集・削除や品切れ切替を行います。</p>
                            <a href="{{ route('admin.menus.index') }}" class="inline-block bg-blue-600 text-white text-center px-4 py-2 rounded hover:bg-blue-700 w-full font-semibold">
                                メニュー管理へ
                            </a>
                        </div>

                        <!-- 売上集計へ -->
                        <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                            <h4 class="font-bold text-gray-800 mb-2">売上集計</h4>
                            <p class="text-sm text-gray-600 mb-4">日別・月別の売上レポートや人気メニューを確認します。</p>
                            <a href="{{ route('admin.sales.index') }}" class="inline-block bg-indigo-600 text-white text-center px-4 py-2 rounded hover:bg-indigo-700 w-full font-semibold">
                                売上集計へ
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>