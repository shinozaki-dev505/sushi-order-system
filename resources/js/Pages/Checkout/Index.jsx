import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ activeTables }) {
    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">お会計 - 卓選択</h2>}
        >
            <Head title="会計画面 - 卓選択" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-bold mb-4">現在ご利用中の卓一覧</h3>

                        {activeTables.length === 0 ? (
                            <p className="text-gray-500">現在、お会計対象の卓はありません。</p>
                        ) : (
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                                {activeTables.map((table) => (
                                    <Link
                                        key={table.id}
                                        href={typeof route === 'function' ? route('checkout.show', table.id) : `/checkout/${table.id}`}
                                        className="block p-4 text-center text-lg font-bold text-blue-600 border border-blue-500 rounded-lg hover:bg-blue-50 transition"
                                    >
                                        {table.table_number} 番席（¥{(table.total_amount || 0).toLocaleString()}）
                                    </Link>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}