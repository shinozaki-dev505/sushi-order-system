<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインしており、かつ is_admin が true（管理者）であるか判定
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        // 管理者でない場合はダッシュボード等へリダイレクト（または 403 エラー）
        return redirect()->route('admin.dashboard')->with('error', '管理者権限がありません。');
    }
}
