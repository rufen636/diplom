<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
//        if (!auth()->check()) {
//            abort(401, 'Unauthenticated');
//        }
//
//        $user = auth()->user();
//
//        // Получаем все роли из параметров middleware
//        // Может быть несколько: 'role:admin,manager' или 'role:admin|manager'
//        $requiredRoles = $this->parseRoles($roles);
//
//        // Проверяем, есть ли у пользователя хотя бы одна из требуемых ролей
//        if (!$this->userHasAnyRole($user, $requiredRoles)) {
//            abort(403, 'You do not have the required role(s)');
//        }
        return $next($request);
    }
}
