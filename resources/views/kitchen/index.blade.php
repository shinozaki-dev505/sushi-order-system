<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('厨房（キッチン）モニター') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">注文一覧</h3>
                    <div class="flex items-center gap-3">
                        <span class="bg-gray-200 text-gray-700 text-sm px-3 py-1 rounded-full">自動更新中（10秒間隔）</span>
                        <button onclick="location.reload()" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded transition">
                            手動更新
                        </button>
                    </div>
                </div>

                @if($orders->isEmpty())
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 text-center py-10 rounded-lg text-lg">
                        現在、未提供の注文はありません。
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($orders as $order)
                            <div class="border rounded-lg shadow-sm overflow-hidden flex flex-col justify-between {{ $order->status === 'pending' ? 'border-red-400' : 'border-yellow-400' }}">
                                <!-- カードヘッダー -->
                                <div class="p-4 flex justify-between items-center text-white {{ $order->status === 'pending' ? 'bg-red-500' : 'bg-yellow-500' }}">
                                    <h4 class="text-xl font-bold">{{ $order->table->table_number ?? $order->table_id }} 番席</h4>
                                    <span class="bg-white text-gray-800 text-sm font-semibold px-2 py-1 rounded">
                                        {{ $order->created_at->format('H:i') }} 注文
                                    </span>
                                </div>

                                <!-- カードボディ -->
                                <div class="p-4 flex-grow bg-white">
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($order->items as $item)
                                            <li class="py-3 flex justify-between items-center text-lg">
                                                <span class="font-bold text-gray-800">{{ $item->menu->name ?? 'メニュー情報なし' }}</span>
                                                <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-base font-bold">
                                                    × {{ $item->quantity }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- カードフッター -->
                                <div class="p-4 bg-gray-50 border-t border-gray-100">
                                    @if($order->status === 'pending')
                                        <button onclick="updateStatus({{ $order->id }}, 'cooking')" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                                            調理開始
                                        </button>
                                    @elseif($order->status === 'cooking')
                                        <button onclick="updateStatus({{ $order->id }}, 'served')" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                                            提供完了
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
    // 10秒ごとに自動リロード
    setInterval(function() {
        location.reload();
    }, 10000);

    // ステータス更新処理
    function updateStatus(orderId, status) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/kitchen/orders/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('ステータスの更新に失敗しました');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('通信エラーが発生しました');
        });
    }
    </script>
</x-app-layout>