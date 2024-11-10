Отображение SQL-запроса в браузере

В метод класса 'AppServiceProvider' добавляем

public function boot()
{   
    #Отображение SQL-кода запроса
    DB::listen(function ($query) {
        dump($query->sql);
    });
}
