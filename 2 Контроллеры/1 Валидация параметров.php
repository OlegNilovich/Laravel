<?php

#1 способ добавления валидации параметру {post}
#В файле Providers/RouteServiceProvider.php в функцию function boot() добавляем:
Route::pattern('post', '[0-9]+');

#2 способ добавления валидации параметру {post}
#В файле Providers/RouteServiceProvider.php в функцию function boot() добавляем:
Route::pattern('id', '[0-9]+');

#Теперь параметрам любых ресурсов мы можем давать псевдоним 'id'
Route::resource('/posts', 'PostController', ['parameters' => ['posts' => 'id'] ]);
Route::resource('/users', 'UserController', ['parameters' => ['users' => 'id'] ]);
#URL  http://laravel/page/about     подключит вид   'about.blade.php'
#URL  http://laravel/page/contact   подключит вид   'contact.blade.php'

