<?php

# Список всех маршрутов: php artisan route:list
# Список маршрутов с префиксом: php artisan route:list --path=admin/cat

#Маршруты блога
Route::get('/', 'PostController@index')->name('home');
Route::get('/article/{slug}', 'PostController@show')->name('posts.single');
Route::get('/tag/{slug}', 'TagController@show')->name('tags.single');
Route::get('/category/{slug}', 'CategoryController@show')->name('categories.single');
Route::get('/search', 'SearchController@index')->name('search');

# Создаем маршруты администратора
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('/', 'MainController@index')->name('admin.index');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/posts', 'PostController');
    Route::resource('/tags', 'TagController');
});

# Создаем маршруты гостя
Route::group(['middleware' => 'guest'], function() {
    Route::get('/register', 'UserController@create')->name('register.create');
    Route::post('/register', 'UserController@store')->name('register.store');
    Route::get('/login', 'UserController@loginForm')->name('login.create');
    Route::post('/login', 'UserController@login')->name('login');
});

# Создаем маршруты пользователя
Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', 'UserController@logout')->name('logout');
});

