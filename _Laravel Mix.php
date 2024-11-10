<?php

//  СОЗДАЕМ ПРЕДСТАВЛЕНИЕ НА БАЗЕ ШАБЛОНА AdminLTE 3.0.5  ///////////////////////////

# Скачиваем шаблон AdminLTE 3.0.5 (https://github.com/ColorlibHQ/AdminLTE/releases)
# Копируем верстку из AdminLTE-3.0.5/pages/examples/blank.html
# В представление (resources/views/admin/index.blade.php)

# Создаем папки resources/assets/admin/plugins и resources/assets/front

# Копируем папки (jquery, bootstrap, fontawesome-free) из AdminLTE-3.0.5/plugins
# В папку resources/assets/admin/plugins

# Копируем папки (select2, select2-bootstrap4-theme) из AdminLTE-3.0.5/plugins
# В папку resources/assets/admin/plugins

# Копируем папки (css, img, js) из AdminLTE-3.0.5/dist
# В папку resources/assets/admin/


//  КОМПИЛИРУЕМ ФАЙЛЫ СТИЛЕЙ И СКРИПТОВ С ПОМОЩЬЮ WEBPACK.MIX  ///////////////////////

# Прописываем пути для компиляции в файле (webpack.mix.js)
mix.styles([
    'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/admin/plugins/select2/css/select2.css',
    'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css',
    'resources/assets/admin/css/adminlte.min.css'
], 'public/assets/admin/css/admin.css');

mix.scripts([
    'resources/assets/admin/plugins/jquery/jquery.min.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/admin/plugins/select2/js/select2.full.js',
    'resources/assets/admin/js/adminlte.min.js',
    'resources/assets/admin/js/demo.js'
], 'public/assets/admin/js/admin.js');

mix.copyDirectory('resources/assets/admin/img', 'public/assets/admin/img');
mix.copyDirectory('resources/assets/admin/plugins/fontawesome-free/webfonts', 'public/assets/admin/webfonts');

mix.copy('resources/assets/admin/css/adminlte.min.css.map', 'public/assets/admin/css/adminlte.min.css.map');

#Стили фронт части блога
mix.styles([
    'resources/assets/front/css/bootstrap.css',
    'resources/assets/front/css/font-awesome.min.css',
    'resources/assets/front/style.css',
    'resources/assets/front/css/animate.css',
    'resources/assets/front/css/responsive.css',
    'resources/assets/front/css/colors.css',
    'resources/assets/front/css/version/marketing.css'
], 'public/assets/front/css/front.css');

mix.scripts([
    'resources/assets/front/js/jquery.min.js',
    'resources/assets/front/js/tether.min.js',
    'resources/assets/front/js/bootstrap.min.js',
    'resources/assets/front/js/animate.js',
    'resources/assets/front/js/custom.js',
], 'public/assets/front/js/front.js');

mix.copyDirectory('resources/assets/front/fonts', 'public/assets/front/fonts');
mix.copyDirectory('resources/assets/front/images', 'public/assets/front/images');
mix.copyDirectory('resources/assets/front/upload', 'public/assets/front/upload');

# Устанавливаем старую версию Node.js v16 (иначе будет ошибка компиляции)
# Устанавливаем консоль Cygwin64 Terminal (если не установлено)
# Устанавливаем Laravel Mix с помощью консоли Cygwin в папке проекта: npm install
# Обновляем Laravel Mix командой: npm update
# Запускаем сборку командой: npm run dev

# В файле (index.blade.php) подключаем стили, скрипты, картинки
# Строка 10:   <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
# Строка 54:   <img src="{{ asset('assets/admin/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
# Строка 70:   <img src="{{ asset('assets/admin/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
# Строка 86:   <img src="{{ asset('assets/admin/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
# Строка 142:  <img src="{{ asset('assets/admin/img/AdminLTELogo.png') }}"
# Строка 154:  <img src="{{ asset('assets/admin/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
# Строка 763:  <script src="{{ asset('assets/admin/js/admin.js') }}"></script>

# Статические элементы помещаем в базовый шаблон /views/admin/layouts/layout.blade.php
# Вырезаем секцию контента и помещаем в /views/admin/index.blade.php

# Если вид страницы не меняется - очищаем кеш командой: php artisan view:clear

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

#Шаблон блога: https://www.free-css.com/free-css-templates/page244/markedia
