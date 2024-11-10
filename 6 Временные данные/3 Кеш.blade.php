<?php

use Illuminate\Support\Facades\Cache;
#Импортируем класс-фасад для работы с кешем Cache::put()
#Кеш по умолчанию хранится в папке  storage/framefork/cache/data


class HomeController extends Controller
{
	public function index(Request $request)
	{
		#Помещаем данные в кеш на 60 секунд
		Cache::put('key', 'value', 60);

		#Помещаем данные в кеш бессрочно
		Cache::forever('key', 'value');
		Cache::put('key', 'value');

		#Получаем данные из кеша
		Cache::get('key');

		#Получаем и удаляем данные из кеша
		Cache::pull('key');

		#Удаляем данные из кеша
		Cache::forget('key');

		#Удаляем все данные из кеша
		Cache::flush();


		#ПРАКТИКА: Если есть список постов в кеше
		if (Cache::has('posts')) {
			#Получаем список постов из кеша
			$posts = Cache::get('posts');
		} else {
			#Иначе получаем список постов из базы данных
			$posts = Post::orderBy('id', 'desc')->get();
			#И помещаем список постов в кеш
			Cache::put('posts', $posts);
		}

		$title = 'Home Page';
		return view('home', compact('title', 'posts'));
	}
}
