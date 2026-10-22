import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({ auth, dailySales, itemSales }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">売上集計</h2>}
        >
            <Head title="売上集計" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    {/* 日別売上集計 */}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-bold mb-4 text-gray-800">日別売上</h3>
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr className="bg-gray-50">
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">日付</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">注文数</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">売上金額</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {dailySales.map((item, index) => (
                                    <tr key={index}>
                                        <td className="px-6 py-4 text-sm text-gray-900">{item.date}</td>
                                        <td className="px-6 py-4 text-sm text-gray-500">{item.total_orders} 件</td>
                                        <td className="px-6 py-4 text-sm text-gray-500">¥{Number(item.total_sales).toLocaleString()}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* 商品別売上集計 */}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-bold mb-4 text-gray-800">商品別売上</h3>
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr className="bg-gray-50">
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">商品名</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">販売数量</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">売上金額</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {itemSales.map((item, index) => (
                                    <tr key={index}>
                                        <td className="px-6 py-4 text-sm text-gray-900">{item.menu ? item.menu.name : '不明な商品'}</td>
                                        <td className="px-6 py-4 text-sm text-gray-500">{item.total_quantity} 個</td>
                                        <td className="px-6 py-4 text-sm text-gray-500">¥{Number(item.total_sales).toLocaleString()}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}