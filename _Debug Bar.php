<?php

# Домашняя страница Дебаг-панели  https://github.com/barryvdh/laravel-debugbar
# Команда для установки:  composer require barryvdh/laravel-debugbar --dev
# Для активации дебаг-панели в файле .env устанавливаем APP_DEBUG=true

# Регестрируем дебаг-панель в файле config/app.php  
return [
	'providers' => [
        Barryvdh\Debugbar\ServiceProvider::class,
	]
];

#Импортируем и используем дебаг-панель в контроллере
#Длинный импорт:   use Barryvdh\Debugbar\Facades\Debugbar;
#Короткий импорт:  use Debugbar;

class HomeController extends Controller
{
	public function index(Request $request)
	{	
		$posts = Post::orderBy('created_at', 'desc');

		#Выводим коллекцию объектов $posts
		Debugbar::warning($posts);
	}
}
