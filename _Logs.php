<?php

#В режиме продакшн в файле .env отключаем режим дебага APP_DEBUG=false
#Меняем строчку LOG_CHANNEL=stack на LOG_CHANNEL=daily (дневной лог файл)
#Узнать об ошибках можно в файле storage/logs/laravel.log

#Запись SQL-запросов в общий файл логов (laravel.log)
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {   
        #Логирование SQL-запросов
        DB::listen(function ($query) {
        	Log::info($query->sql);
        });
  	}
}

/////////////////////////////////////////////////////////////////////////////////////

#Запись логов SQL-запросов в отдельный файл (sql.log)

#В файле logging.php добавляем новый канал 'sqllogs'
return [
	'channels' => [

		#Собственный канал для SQL-логирования
	    'sqllogs' => [
	        'driver' => 'single',
	        'path' => storage_path('logs/sql.log'),
	        'level' => 'debug',
	    ],
	]
];

#Логирование SQL-запросов с использованием канала 'sqllogs'
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {   
        DB::listen(function ($query) {
            Log::channel('sqllogs')->info($query->sql);
        });
  	}
}
