<?php

#MIDDLEWARE - ПОСРЕДНИКИ - ОГРАНИЧЕНИЕ ДОСТУПА К МАРШРУТАМ
#Обработка запросов до того как они попадут в контроллеры

#Добавляем дополнительное поле статуса администратора в таблицу Users
#Миграция: php artisan make:migration add_status_field_to_users --table=users
class AddIsAdminFieldToUsers extends Migration
{
	public function up()
	{
		Schema::table('users', function (Blueprint $table)
		{
			$table->tinyInteger('is_admin')->default(0);
		});
	}

	public function down()
	{
		Schema::table('users', function (Blueprint $table)
		{
			$table->dropColumn('is_admin');
		});
	}
}

#Создаем админский контроллер
class MainController extends Controller
{
	public function index()
	{
		return 'Это администраторская зона';
	}
}

#Создаем класс-посредник: php artisan make:middleware AdminMiddleware
class AdminMiddleware
{
	public function handle($request, Closure $next)
	{   
		#Проверка на авторизацию и статус админа
		if (Auth::check() == true && Auth::user()->is_admin == true) {
			return $next($request);
		}
		
		abort(404);
	}
}

#Регестрируем класс-посредник под псевдонимом 'admin' в файле: app/Http/Kernel.php
class Kernel extends HttpKernel
{
	protected $routeMiddleware = [
		'admin' => \App\Http\Middleware\AdminMiddleware::class,
	];
}

#Определяем редирект в файле app/Htto/Middleware/RedirectIfAuthenticated.php 
class RedirectIfAuthenticated
{
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->check()) {

			#Перенаправление на домашнюю страницу
			return redirect()->home();
		}

		return $next($request);
	}
}

#Маршруты доступные гостю
Route::group(['middleware' => 'guest'], function() {
	Route::get('/register', 'UserController@create')->name('register.create');
	Route::post('/register', 'UserController@store')->name('register.store');
	Route::get('/login', 'UserController@loginForm')->name('login.create');
	Route::post('/login', 'UserController@login')->name('login');
});

#Маршруты доступные авторизированному пользователю
Route::group(['middleware' => 'auth'], function() {
	Route::get('/logout', 'UserController@logout')->name('logout');
});

#Маршруты доступные администрации
// Route::get('/admin', 'Admin\MainController@index')->middleware('admin');
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Admin'], function() {
	Route::get('/', 'MainController@index');
});

?>

<!-- Добавляем ссылку на вход в админ-зону в базовый шаблон layout.blade.php -->
@if(auth()->check() && auth()->user()->is_admin)
    <a href="{{ route('adminzone') }}" class="text-white">Admin-zone</a>
@endif

