<?php

#Laravel-mix / WebPack - Cборка (компиляция) фронт-енд файлов
#Объединение файлов стилей и скриптов в единый файл

#1 Создаем папку resourses/front
#2 Помещаем туда папки js и css из Bootstrap
#3 Создаем папку img с нашими изображениями
#4 Создаем папку fonts со шрифтами 
#5 Копируем файл public/css/main.css в папку resourses/front/css
#6 Помещаем файл jquery-3.5.1.slim.js в resourses/front/js
#8 Устанавливаем консоль Cygwin64 Terminal
#7 Устанавливаем node.js
#8 Проверяем необходимые записимости в файле package.json
#9 Для установки Node-модулей вводим в консоль: npm install
#10 В фале webpack.mix.js указываем файлы для объединения
mix.styles([
   'resources/front/css/bootstrap.css',   #Файл стилей для компиляции
   'resources/front/css/main.css'         #Файл стилей для компиляции
], 'public/css/styles.css');              #Скомпилируемый файл стилей

mix.scripts([
    'resources/front/js/jquery-3.5.1.slim.js',   #Файл скриптов для компиляции
    'resources/front/js/bootstrap.js'            #Файл скриптов для компиляции
], 'public/js/scripts.js');                      #Скомпилируемый файл скриптов

mix.copyDirectory('resources/front/img', 'public/img'); #Перемещаем изображения

mix.browserSync('larawfm'); #Настройка для автообновления браузера

#11.1 Запускаем систему сборки для разработки: npm run dev
#11.2 Или же запускаем систему сборки для прода: npm run prod
#11.3 Команда запускает авто-компиляцию после изменений: npm run watch

#Возможная ошибка во время компиляции:
opensslErrorStack: [ 'error:03000086:digital envelope routines::initialization error' ],
library: 'digital envelope routines',
reason: 'unsupported',
code: 'ERR_OSSL_EVP_UNSUPPORTED'

#Простое решение: Установить старую версию Node.js v16.20.0 
#Другие решения https://weekendprojects.dev/posts/fixed-node-err_ossl_evp_unsupported/#2-upgrade-your-webpack-version-to-v5540

?>

{{-- 12 Подключаем стили и скрипты в базовом шаблоне layout.blade.php --}}
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
<link href="http://larawfm/css/styles.css" rel="stylesheet">

<script src="{{ asset('js/scripts.js') }}"></script>
<script src="http://larawfm/js/scripts.js"></script>

{{-- 13 Добавляем внизу страницы шаблона layout.blade.php место для скрипта --}}
@yield('scripts')

{{-- 14 Добавляем скрипт внизу страницы home.blade.php --}}
@section('scripts')
  <script>
    alert(Это скрипт со страницы Home);
  </script>
@endsection

{{-- 15 Добавляем скрипт внизу страницы create.blade.php --}}
@section('scripts')
  <script>
    alert(Это скрипт со страницы Create);
  </script>
@endsection 
