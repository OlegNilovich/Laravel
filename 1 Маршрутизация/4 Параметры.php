<?php
// URL-адрес   http://laravel.loc/post/123/test
// Протокол    http
// Домен       laravel.loc
// URI-адрес   /post/123/test
// Маршрут     /post
// Параметры   /123/test

// [0-9]+     Разрешено: цифры от 0 до 9. Требуется: минимум 1 символ
// [A-Za-z-]+ Разрешено: большие и маленькие буквы, тире. Требуется мин 1 символ


// Динамические {параметры} попадают в аргументы колбек функции
Route::get('/post/{id}', function($post_id) {
	// использование значение парамететра
    return "Пост с айди: $post_id";
});


// Подключение страницы с двумя динамическими парамеирами {id} и {slug}
Route::get('/post/{id}/{slug}', function($id, $slug) {
    return "Первый параметр 1: $id | Второй параметр 2: $slug";
});


// Подключение страницы с двумя динамическими парамеирами {num} и {text}
// С указанием ограничений в ->where() с помощью регулярных выражений
Route::get('/post/{num}/{text}', function($onlyNum, $onlyText) {
    return "Первый параметр 1: $onlyNum | Второй параметр 2: $onlyText";
})->where(['num' => '[0-9]+', 'text' => '[A-Za-z]+']);


// Подключаем страницу, но уже с глобальными ограничениями параметров
Route::get('/post/{num}/{text}', function($onlyNum, $onlyText) {
    return "Цифровой параметр: $onlyNum | Буквенный параметр: $onlyText";
});

// Для этого в файле Project/app/Providers/RouteServiceProvider.php
// Добавляем глобальные правила в тело функции boot()
Route::pattern('num', '[0-9]+');
Route::pattern('text', '[A-Za-z]+');


// Подключение страницы с необязательныи параметрами маршрута
Route::get('/post/{id}/{slug?}', function($id, $slug = null) {
    return "Обязательный параметр: $id | Необязательный параметр: $slug";
});
