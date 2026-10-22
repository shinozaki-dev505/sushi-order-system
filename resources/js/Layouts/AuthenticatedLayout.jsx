import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function AuthenticatedLayout({ header, children }) {
    const user = usePage().props.auth.user;
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    // Ziggy (route()) が安全に使えるかどうかの判定関数
    const isRouteActive = (routeName) => {
        try {
            return typeof route === 'function' ? route().current(routeName) : false;
        } catch (e) {
            return false;
        }
    };

    // 安全に URL を取得するヘルパー関数
    const getRouteUrl = (routeName, fallbackPath) => {
        try {
            return typeof route === 'function' ? route(routeName) : fallbackPath;
        } catch (e) {
            return fallbackPath;
        }
    };

    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="border-b border-gray-100 bg-white">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 justify-between">
                        <div className="flex">
                            {/* ロゴ */}
                            <div className="flex shrink-0 items-center">
                                <Link href={getRouteUrl('dashboard', '/dashboard')}>
                                    <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            {/* PC用 ナビゲーションメニュー */}
                            <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink href={getRouteUrl('dashboard', '/dashboard')} active={isRouteActive('dashboard')}>
                                    ダッシュボード
                                </NavLink>

                                {/* 【スタッフ機能】厨房画面 */}
                                <NavLink href={getRouteUrl('kitchen.index', '/kitchen')} active={isRouteActive('kitchen.*')}>
                                    厨房モニター
                                </NavLink>

                                {/* 【スタッフ機能】会計画面：route('checkout.index') に修正 */}
                                <NavLink href={getRouteUrl('checkout.index', '/checkout')} active={isRouteActive('checkout.*')}>
                                    会計画面
                                </NavLink>

                                {/* 【管理者専用機能】 */}
                                {(user?.is_admin || user?.role === 'admin') && (
                                    <>
                                        <NavLink href={getRouteUrl('admin.menus.index', '/admin/menus')} active={isRouteActive('admin.menus.*')}>
                                            メニュー管理
                                        </NavLink>

                                        <NavLink href={getRouteUrl('admin.sales.index', '/admin/sales')} active={isRouteActive('admin.sales.*')}>
                                            売上集計
                                        </NavLink>

                                        <NavLink href={getRouteUrl('admin.users.index', '/admin/users')} active={isRouteActive('admin.users.*')}>
                                            ユーザー管理
                                        </NavLink>
                                    </>
                                )}
                            </div>
                        </div>

                        {/* ユーザーアカウントメニュー */}
                        <div className="hidden sm:ms-6 sm:flex sm:items-center">
                            <div className="relative ms-3">
                                <Dropdown>
                                    <Dropdown.Trigger>
                                        <span className="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                className="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {user?.name}
                                                <svg
                                                    className="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fillRule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clipRule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </Dropdown.Trigger>

                                    <Dropdown.Content>
                                        <Dropdown.Link href={getRouteUrl('profile.edit', '/profile')}>
                                            プロフィール編集
                                        </Dropdown.Link>
                                        <Dropdown.Link href={getRouteUrl('logout', '/logout')} method="post" as="button">
                                            ログアウト
                                        </Dropdown.Link>
                                    </Dropdown.Content>
                                </Dropdown>
                            </div>
                        </div>

                        {/* モバイル用ハンバーガーボタン */}
                        <div className="-me-2 flex items-center sm:hidden">
                            <button
                                onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                                className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {/* モバイル表示用のドロップダウン */}
                <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
                    <div className="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink href={getRouteUrl('dashboard', '/dashboard')} active={isRouteActive('dashboard')}>
                            ダッシュボード
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={getRouteUrl('kitchen.index', '/kitchen')} active={isRouteActive('kitchen.*')}>
                            厨房モニター
                        </ResponsiveNavLink>
                        <ResponsiveNavLink href={getRouteUrl('checkout.index', '/checkout')} active={isRouteActive('checkout.*')}>
                            会計画面
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>

            {/* ページヘッダー */}
            {header && (
                <header className="bg-white shadow">
                    <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">{header}</div>
                </header>
            )}

            {/* メインコンテンツ */}
            <main>{children}</main>
        </div>
    );
}