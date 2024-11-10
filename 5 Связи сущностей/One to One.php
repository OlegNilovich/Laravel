<?php

# ONE TO ONE - ОДИН К ОДНОМУ

# Пользователь имеет один Канал (Канал пренадлежит одному Пользователю)

#Таблица для Пользователей
Schema::create('people', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->timestamps();
});

#Таблица для Каналов
Schema::create('chanels', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->timestamps();
    $table->integer('person_id');
});

#Модель пользователя
class Person extends Model
{   
    #Свойство $person->chanel
    public function chanel()
    {
        return $this->hasOne(Chanel::class);
        // return this->hasOne('App\Chanel');
    }
}

#Модель канала
class Chanel extends Model
{
    #Свойство $chanel->person
    public function person()
    {   
        return $this->belongsTo(Person::class);

        #Второй аргумент название поля внешнего ключа (опционально)
        return $this->belongsTo(Person::class, 'person_id');
    }
}

#Контроллер
class HomeController extends Controller
{
	public function index()
	{	
		$person = Person::find(1);
		$chanel = Chanel::find(1);

		#Обращения к свойствам объектов через связанные объекты
		echo $chanel->person->name . " has " . $chanel->title;
		echo $person->chanel->title . " belongs to " . $person->name;
	}
}
