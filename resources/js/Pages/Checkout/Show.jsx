import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Show({ table, summary, totalAmount }) {
    const { post, processing } = useForm();

    const handlePay = (e) => {
        e.preventDefault();
        if (confirm('お会計を完了してよろしいですか？')) {
            const url = typeof route === 'function' ? route('checkout.pay', table.id) : `/checkout/${table.id}/pay`;
            post(url);
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    {table.table_number} 番席 - お会計詳細
                </h2>
            }
        >
            <Head title={`${table.table_number} 番席 - お会計詳細`} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-xl font-bold text-gray-800">
                                {table.table_number} 番席 - お会計伝票
                            </h3>
                            <Link
                                href={typeof route === 'function' ? route('checkout.index') : '/checkout'}
                                className="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition"
                            >
                                卓選択に戻る
                            </Link>
                        </div>

                        <div className="border rounded-lg overflow-hidden mb-6">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-gray-800 text-white">
                                        <th className="py-3 px-4 font-semibold text-sm">商品名</th>
                                        <th className="py-3 px-4 font-semibold text-sm text-right">単価</th>
                                        <th className="py-3 px-4 font-semibold text-sm text-center">数量</th>
                                        <th className="py-3 px-4 font-semibold text-sm text-right">小計</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {Object.entries(summary).map(([itemName, detail]) => (
                                        <tr key={itemName} className="hover:bg-gray-50">
                                            <td className="py-3 px-4 text-gray-800">{itemName}</td>
                                            <td className="py-3 px-4 text-right text-gray-600">
                                                ¥{detail.price.toLocaleString()}
                                            </td>
                                            <td className="py-3 px-4 text-center text-gray-800">
                                                {detail.quantity}
                                            </td>
                                            <td className="py-3 px-4 text-right text-gray-800 font-medium">
                                                ¥{detail.subtotal.toLocaleString()}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                                <tfoot>
                                    <tr className="bg-gray-100 font-bold text-lg">
                                        <td colSpan="3" className="py-4 px-4 text-right text-gray-700">
                                            合計金額（税込）
                                        </td>
                                        <td className="py-4 px-4 text-right text-red-600">
                                            ¥{totalAmount.toLocaleString()}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <form onSubmit={handlePay}>
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full py-4 bg-green-600 hover:bg-green-700 text-white font-bold text-lg rounded-lg shadow-md transition disabled:opacity-50"
                            >
                                会計完了（¥{totalAmount.toLocaleString()}）
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}