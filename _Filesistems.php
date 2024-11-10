<?php

#Меняем папку хранения файлов в файле /config/filesystems.php чтобы
#Файлы сохранялись в папке с текушей датой /public/uploads/images/2023-05-26

return [

	// 'default' => env('FILESYSTEM_DRIVER', 'local'),
	'default' => env('FILESYSTEM_DRIVER', 'public'),

        'public' => [
            'driver' => 'local',

            // 'root' => storage_path('app/public'),
            'root' => public_path('uploads'),
        ],
];
