<?php

// Правило: конкретные маршруты должны быть выше общих маршрутов

// Project/routes/web.php

Route::get('/', function () {
	// две переменные, которые мы хотим передать в вид
	// Вывод переменной в блейд-шаблоне {{ $name }}
	$res = 2 + 5;
	$name = 'Alex';

	// 1 способ передачи данных
	// Параметры ('блейд-шаблон')->('псевдоним', $переменная)
	return view('home')->with('var', $res);

	// 2 способ передачи данных
	// Параметры ('блейд-шаблон', ['псевдоним' => $переменная])
	return view('home', ['var' => $res, 'name' => $name]);

	// 3 способ передачи данных (предпочтительный)
	// Параметры ('блейд-шаблон', compact('переменная, переменная'))
	return view('home', compact('res', 'name'));

	/* функция компакт возвращает ассоциотивный массив, 
	где ключ - название переменной, а значение - значение переменной */
});


// Маршрут домашней страницы с именем 'home'
Route::get('/', function () {
    $res = 2 + 5;
    $name = 'Alex';
    return view('home', compact('res', 'name'));
})->name('home');

// Маршрут About
Route::get('/about', function () {
    return '<h1> About Page </h1>';
});

// Маршрут Test для простой статичной информационной страницы
Route::view('/test', 'test', ['test' => 'test value']);

// Именной маршрут с uri '/contact' и псевдонимом 'contact' 
Route::match(['get', 'post', 'put'], '/contact', function() {
    return view('contact');
})->name('contact');

// Маршрут перенаправления на другую страницу со статусом по умолчанию 302
Route::redirect('/test', '/');

// Маршрут перенаправления на другую страницу со статусом по умолчанию 301
Route::permanentRedirect('/about', '/contact2');

// Маршрут с одним динамическим параметром {id}
Route::get('/post/{id}', function($post_id) {
    return "Первый параметр: $post_id";
});

// Маршрут с двумя динамическими парамеирами {id} и {slug}
// С указанием ограничений параметров регулярными выражениями через метод ->where()
Route::get('/post/{id}/{slug}', function($id, $slug) {
    return "Первый параметр: $id | Второй параметр: $slug";
})->where(['id' => '[0-9]+', 'slug' => '[A-Za-z0-9-]+']);

// Маршрут с двумя динамическими парамеирами {id} и {slug}
// Ограничения этих параметров указаны глобально в файле RouteServiceProvider.php
Route::get('/post/{id}/{slug}', function($id, $slug) {
    return "Цифровой параметр: $id | Буквенно-цифровой параметр: $slug";
});

// Первый маршрут с именем 'post' и необязательным параметром {slug?}
Route::get('/post/{id}/{slug?}', function($id, $slug = null) {
    return "Обязательный параметр: $id | Необязательный параметр: $slug";
})->name('post');

// Группа маршрутов с префиксом 'admin' и именем 'admin.'
Route::prefix('admin')->name('admin.')->group(function() {

    Route::get('/posts', function() {
        return 'Posts list';
    });

    Route::get('/post/create', function() {
        return 'Post create';
    });

    // Второй маршрут изменил имя с 'post' на 'admin.post'
    Route::get('/post/{id}/edit', function($id) {
        return "Edit post with id: $id";
    })->name('post');
});   

// Маршрут перенаправляет несуществующие адреса на страницу с ошибкой
// Project/resources/views/errors/404.blade.php
// Выводим текст ошибки в виде {{ $exception->getMessage() }}
Route::fallback(function () {
    abort(404, 'This is error message');
});
