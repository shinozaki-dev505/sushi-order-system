import React, { useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';

export default function KitchenIndex({ auth, orders }) {

    // 10秒ごとにバックグラウンドで注文データを再取得（画面のチラつきなし）
    useEffect(() => {
        const interval = setInterval(() => {
            router.reload({ only: ['orders'], preserveScroll: true });
        }, 10000);

        return () => clearInterval(interval);
    }, []);

    // ステータス更新処理
    const handleStatusUpdate = (orderId, nextStatus) => {
        router.patch(`/kitchen/orders/${orderId}/status`, {
            status: nextStatus,
        }, {
            preserveScroll: true,
        });
    };

    // ステータスごとの設定（表示ラベル、ボタンカラー、枠線カラーなど）
    const statusConfig = {
        pending: {
            label: '未調理',
            btnText: '調理開始',
            btnBg: 'bg-yellow-500 hover:bg-yellow-600',
            nextStatus: 'cooking',
            cardBorder: 'border-red-400',
            headerBg: 'bg-red-500',
        },
        cooking: {
            label: '調理中',
            btnText: 'お届けへ',
            btnBg: 'bg-blue-500 hover:bg-blue-600',
            nextStatus: 'delivering',
            cardBorder: 'border-yellow-400',
            headerBg: 'bg-yellow-500',
        },
        delivering: {
            label: 'お届け中',
            btnText: '提供完了',
            btnBg: 'bg-green-600 hover:bg-green-700',
            nextStatus: 'served',
            cardBorder: 'border-blue-400',
            headerBg: 'bg-blue-500',
        },
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">厨房（キッチン）モニター</h2>}
        >
            <Head title="厨房モニター" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        
                        {/* ヘッダーエリア */}
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-2xl font-bold text-gray-800">注文一覧</h3>
                            <div className="flex items-center gap-3">
                                <span className="bg-gray-200 text-gray-700 text-sm px-3 py-1 rounded-full font-medium">
                                    自動更新中（10秒間隔）
                                </span>
                                <button
                                    onClick={() => router.reload({ only: ['orders'], preserveScroll: true })}
                                    className="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded transition shadow-sm"
                                >
                                    手動更新
                                </button>
                            </div>
                        </div>

                        {/* 注文カード一覧 */}
                        {orders.length === 0 ? (
                            <div className="bg-blue-50 border border-blue-200 text-blue-700 text-center py-12 rounded-lg text-lg font-bold">
                                現在、未提供の注文はありません。
                            </div>
                        ) : (
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {orders.map((order) => {
                                    const config = statusConfig[order.status] || statusConfig.pending;
                                    const orderTime = new Date(order.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                                    return (
                                        <div
                                            key={order.id}
                                            className={`border-2 rounded-lg shadow-sm overflow-hidden flex flex-col justify-between bg-white ${config.cardBorder}`}
                                        >
                                            {/* カードヘッダー：卓上番号 & 注文時刻 */}
                                            <div className={`p-4 flex justify-between items-center text-white ${config.headerBg}`}>
                                                <div className="flex items-center gap-2">
                                                    <h4 className="text-2xl font-black tracking-wide">
                                                        {order.table?.table_number ?? order.table_id} 番席
                                                    </h4>
                                                    <span className="text-xs bg-black/20 px-2 py-0.5 rounded">
                                                        {config.label}
                                                    </span>
                                                </div>
                                                <span className="bg-white text-gray-800 text-sm font-semibold px-2 py-1 rounded shadow-sm">
                                                    {orderTime} 注文
                                                </span>
                                            </div>

                                            {/* カードボディ：注文品目リスト */}
                                            <div className="p-4 flex-grow bg-white">
                                                <ul className="divide-y divide-gray-200">
                                                    {order.items?.map((item) => (
                                                        <li key={item.id} className="py-3 flex justify-between items-center text-lg">
                                                            <span className="font-bold text-gray-800">
                                                                {item.menu?.name ?? 'メニュー情報なし'}
                                                            </span>
                                                            <span className="bg-gray-800 text-white px-3 py-1 rounded-full text-base font-bold">
                                                                × {item.quantity}
                                                            </span>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </div>

                                            {/* カードフッター：ステータス進行ボタン */}
                                            <div className="p-4 bg-gray-50 border-t border-gray-100">
                                                <button
                                                    onClick={() => handleStatusUpdate(order.id, config.nextStatus)}
                                                    className={`w-full text-white font-bold py-3 px-4 rounded-lg text-lg transition shadow ${config.btnBg}`}
                                                >
                                                    {config.btnText}
                                                </button>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        )}

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}