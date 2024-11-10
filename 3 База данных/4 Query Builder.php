<?php

// Строитель запросов работает с базой данных через Контроллер
// И возвращает коллекцию объектов(записей) из базы данных

// Получить все записи
$data = DB::table('posts')->get();

// Получить все записи лимит 5
$data = DB::table('posts')->limit(5)->get();

// Получить все записи по возрастанию поля 'id'
$data = DB::table('posts')->orderBy('id', 'asc')->get();

// Получить все записи по убыванию поля 'id'
$data = DB::table('posts')->orderBy('id', 'desc')->get();

// Получить значения полей 'id' и 'title' всех записей
$data = DB::table('posts')->select('id', 'title')->get();

// Получить значения полей 'id' и 'title' первой записи
$data = DB::table('posts')->select('title')->first();

// Получить одну запись, где 'id' равен 5
$data = DB::table('posts')->find('5');

// Получить записи, где 'id' равен 6
$data = DB::table('posts')->where('id', '<', 6)->get();

// Получить значение поля одной записи, где 'id' равен 7
$data = DB::table('posts')->where('id', '=', 7)->value('title');

// Получить записи, где 'id' больше 2, но меньше 8
$data = DB::table('posts')->where([ ['id', '>', 2], ['id', '<', 8], ])->get();

// Получить и-массив записей, где ключи - индексы, значения - поле 'content' 
$data = DB::table('posts')->pluck('content');

// Получить а-массив записей, где ключи - поле 'title', а значения - поле 'content' 
$data = DB::table('posts')->pluck('content', 'title');

// Получить одно самое максимальное значение из поля 'age'
$data = DB::table('users')->max('age');

// Получить одно самое минимальное значение из поля 'age'
$data = DB::table('users')->min('age');

// Получить сумму значений поля 'likes' для всех записей
$data = DB::table('posts')->sum('id');

// Получить средний возраст пользователей
$data = DB::table('users')->avg('age');

// Получить записи, только с уникальным значением поля 'title'
$data = DB::table('posts')->select('title')->distinct()->get();

// Объединить две таблицы по заданным полям
$data = DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->get();

// Обединить две таблицы с помощью левого соединения
$data = DB::table('posts')->leftJoin('users', 'posts.user_id', '=', 'users.id')->get();

// Обединить две таблицы с помощью правого соединения
$data = DB::table('posts')->rightJoin('users', 'posts.user_id', '=', 'users.id')->get();
