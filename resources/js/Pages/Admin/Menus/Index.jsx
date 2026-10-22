import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';

export default function Index({ auth, menus, flash }) {
    const handleDelete = (id) => {
        if (confirm('本当に削除しますか？')) {
            router.delete(route('admin.menus.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">メニュー管理</h2>}
        >
            <Head title="メニュー管理" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {flash?.success && (
                        <div className="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {flash.success}
                        </div>
                    )}

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div className="flex justify-end mb-4">
                            <Link
                                href={route('admin.menus.create')}
                                className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm"
                            >
                                + 新規メニュー追加
                            </Link>
                        </div>

                        {menus.data.length === 0 ? (
                            <p className="text-gray-500">登録されているメニューはありません。</p>
                        ) : (
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr className="bg-gray-50">
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">商品名</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">価格</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">カテゴリ</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">説明</th>
                                        <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">操作</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {menus.data.map((menu) => (
                                        <tr key={menu.id}>
                                            <td className="px-6 py-4 text-sm text-gray-500">{menu.id}</td>
                                            <td className="px-6 py-4 text-sm font-medium text-gray-900">{menu.name}</td>
                                            <td className="px-6 py-4 text-sm text-gray-500">¥{menu.price.toLocaleString()}</td>
                                            <td className="px-6 py-4 text-sm text-gray-500">{menu.category}</td>
                                            <td className="px-6 py-4 text-sm text-gray-500">{menu.description}</td>
                                            <td className="px-6 py-4 text-right text-sm font-medium">
                                                <Link
                                                    href={route('admin.menus.edit', menu.id)}
                                                    className="text-indigo-600 hover:text-indigo-900 mr-3"
                                                >
                                                    編集
                                                </Link>
                                                <button
                                                    onClick={() => handleDelete(menu.id)}
                                                    className="text-red-600 hover:text-red-900"
                                                >
                                                    削除
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}