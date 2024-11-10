<?php

# ВАЖНО: Любой вывод dd() dump() и т.д. препятствуют работе с Куки!

use Illuminate\Support\Facades\Cookie;
# 1 Выполняем импорт для работы через фасад Cookie::
# 2 Или работаем с Куки через объект $request->

class HomeController extends Controller
{
	public function index(Request $request)
	{
		#Устанавливаем куку (1 минута)
		Cookie::queue('my_cookie', 'Cookie Value', 1);

		#Получаем значение куки
		dump($request->cookie('my_cookie'));
		dump(Cookie::get('my_cookie'));

		#Удаляем куку
		Cookie::queue(Cookie::forget('my_cookie'));

		return view('home');
	}
