import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';

export default function Edit({ auth, menu }) {
    const { data, setData, put, processing, errors } = useForm({
        name: menu.name || '',
        price: menu.price || '',
        category: menu.category || '握り',
        description: menu.description || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('admin.menus.update', menu.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">メニュー編集</h2>}
        >
            <Head title="メニュー編集" />

            <div className="py-12">
                <div className="max-w-2xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700">商品名</label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                {errors.name && <div className="text-red-500 text-sm mt-1">{errors.name}</div>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">価格</label>
                                <input
                                    type="number"
                                    value={data.price}
                                    onChange={(e) => setData('price', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                {errors.price && <div className="text-red-500 text-sm mt-1">{errors.price}</div>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">カテゴリー</label>
                                <select
                                    value={data.category}
                                    onChange={(e) => setData('category', e.target.value)}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="握り">握り</option>
                                    <option value="軍艦巻き">軍艦巻き</option>
                                    <option value="サイドメニュー">サイドメニュー</option>
                                    <option value="デザート・ドリンク">デザート・ドリンク</option>
                                </select>
                                {errors.category && <div className="text-red-500 text-sm mt-1">{errors.category}</div>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700">商品説明</label>
                                <textarea
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                    rows="3"
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="商品の詳細説明を入力してください"
                                />
                                {errors.description && <div className="text-red-500 text-sm mt-1">{errors.description}</div>}
                            </div>

                            <div className="flex items-center justify-between">
                                <Link
                                    href={route('admin.menus.index')}
                                    className="text-sm text-gray-600 underline hover:text-gray-900"
                                >
                                    キャンセル
                                </Link>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-4 py-2 bg-indigo-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none disabled:opacity-25"
                                >
                                    更新する
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}