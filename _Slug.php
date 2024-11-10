<?php

#Устанавливаем пакет Laravel-sluggable https://github.com/cviebrock/eloquent-sluggable
#Команда: composer require cviebrock/eloquent-sluggable

#Добавляем в файл config/app.php
'providers' => [
        Cviebrock\EloquentSluggable\ServiceProvider::class,

#Импортируем класс Sluggable в файле модели
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{   
	#Используем трейт
    use Sluggable;

	#Добавляем метод sluggable
    public function sluggable(): array
    {	
    	#Поле 'slug' возьмет строку из поля 'title' и преобразует её
        return [ 'slug' => [ 'source' => 'title' ] ];
    }
}

#При сохранении Тега в базе, у записи автоматически создастся уникальное поле 'slug'
#Строка 'Привет Мир!' будет преобразована в 'privet-mir', 'privet-mir-2' и так далее 
class MainController extends Controller
{
    public function index()
    {
        $tag = new Tag();
        $tag->title = 'Привет Мир!';
        $tag->save();

        return view('admin.index');
    }
}
