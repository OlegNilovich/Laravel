
Структура представлений

- resources
  - views
    - layouts
      - app.blade.php (главный макет приложения)
      - sidebar.blade.php (боковая панель приложения)
      - navbar.blade.php (навигационное меню приложения)
      - footer.blade.php (подвал приложения)
    - auth
      - login.blade.php (страница входа)
      - register.blade.php (страница регистрации)
      - reset-password.blade.php (страница сброса пароля)
      - verify-email.blade.php (страница подтверждения email)
    - dashboard
      - index.blade.php (главная страница панели управления)
      - users.blade.php (страница списка пользователей)
      - products.blade.php (страница списка продуктов)
      - ...
    - profiles
      - show.blade.php (страница профиля пользователя)
      - edit.blade.php (страница редактирования профиля)
      - ...
    - products
      - index.blade.php (страница списка продуктов)
      - show.blade.php (страница просмотра продукта)
      - create.blade.php (страница создания продукта)
      - edit.blade.php (страница редактирования продукта)
      - ...
    - emails
      - welcome.blade.php (шаблон приветственного письма)
      - password-reset.blade.php (шаблон письма для сброса пароля)
      - ...
    - blog
      - index.blade.php (страница списка статей блога)
      - show.blade.php (страница просмотра отдельной статьи блога)
      - create.blade.php (страница создания новой статьи блога)
      - edit.blade.php (страница редактирования статьи блога)
      - ...
    - ...

___________________________________________________________________________________

{{-- Базовый шаблон layouts/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<header> @section('header') {{-- Здесь находится навигация --}} @show </header>

	<main> @yield('content') {{-- Секция динамического контента --}} </main>

	<footer> @include('layouts.footer') {{-- Подключение футера --}} </footer>
</body>
</html>

___________________________________________________________________________________

{{-- Шаблон контента на странице home.blade.php --}}

@extends('layouts.layout') {{--Подключаем базовый общий шаблон --}}

@section('header') {{-- Переопределяем секцию хедер --}}
@parent{{-- Подключаем родительскую секцию хедер --}}
@endsection

@section('content') {{-- Начало секции контента --}}
<h1>Это Контент на странице home</h1>
@endsection {{-- Конец секции контента --}}

___________________________________________________________________________________

{{-- Шаблон контента на странице about.blade.php --}}

@extends('layouts.layout') {{--Подключаем базовый общий шаблон --}}

@section('content') {{-- Начало секции контента --}}
<h1>Это Контент на странице About</h1>
@endsection {{-- Конец секции контента --}}

___________________________________________________________________________________

{{-- Шаблон футера на странице layouts/footer.blade.php --}}
<p> Это футер </p>
