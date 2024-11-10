<?php

# ВАЖНО: Любой вывод dd() dump() и т.д. препятствуют работе с Куки!

#Сессия сохраняет данные пользователя между страницами сайта
#Файлы сесий по умолчанию находится в storage/framework/sessions
#Сессия доступна через объект $request или функция-хелпер session()
# _flash переменная хранит данные до следующего запроса страницы

#Структура файла сессии
["_token" => "TlCnCgcFqPn1Ujm9rSd2IiKMj07ifl5tJ0QkWzwx",
"_previous" => ["url" => "http://larawfm/create"],
"_flash" => ["old" => [], "new" => [] ]];

class HomeController extends Controller
{	
	#ПРАКТИКА СЕССИЙ
	public function index(Request $request)
	{ 	
		#Получение данных
		session()->all();
		session('ключ');
		session('корзина')[0]['наименование'];


		#Создание одиночного значения
		session()->put('ключ', 'значение');

		#Создание массива данных
		session(['корзина' => [
			['id' => 1, 'наименование' => 'продукт 1'],
			['id' => 2, 'наименование' => 'продукт 2'],
		]]);

		#Добавление дополнительных значений
		session()->push('корзина', ['id' => 3, 'наименование' => 'продукт 3']);


		#Получение и удаление значения
		session()->pull('ключ');

		#Удаление значения
		session()->forget('ключ');

		#Удаление всех данных сессии
		session()->flush();


		return view('home');
	}

	#ПРАКТИКА ВРЕМЕННОЙ ПЕРЕМЕННОЙ _flash
	public function store(Request $request)
	{
		#Создаем флеш-сообщение об успешном создании поста
		session()->flash('success', 'Данные успешно сохранены');

		Post::create($request->all());
		return redirect()->route('home');
	}
}

?>

{{-- Выводим сообщение об успешном создании Поста на странице 'home' --}}
@if(session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@endif
