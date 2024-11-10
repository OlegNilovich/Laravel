<?php

#Создаем админский посредник: php artisan make:middleware AdminMiddleware
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {   
        if (Auth::check() && Auth::user()->is_admin === 1) { 
            return $next($request);
        }
        abort(404);
    }
}

#В посреднике авторизованного пользователя меняем редирект
class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            #Перенаправляем на домашнюю страницу
            return redirect()->route('home');
        }

        return $next($request);
    }
}

#Регестрируем посредника AdminMiddleware в файле  /app/Http/Kernel.php
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
