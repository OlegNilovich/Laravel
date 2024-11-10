<?php

#СИДЫ И ФАБРИКИ служат для наполнения базы данных фейковыми данными

#Создаем класс-фабрику: php artisan make:factory PostFactory -m Post
#Создаем класс-сидер: php artisan make:seeder PostSeeder
#Запускаем конкретный сидер: php artisan db:seed --class=PostSeeder
#Запускаем все сидеры: php artisan db:seed

//database/factories/PostFactory.php
$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'content' => $faker->paragraph(1),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
        'category_id' => $faker->numberBetween(1, 5),
    ];
});

//database/seeds/PostSeeder.php
class PostSeeder extends Seeder
{
    public function run()
    {	
    	#Вторым аргументом передается количество записей
        factory(\App\Post::class, 5)->create();
    }
}

//database/seeds/DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{	
	#В метод можно записать вызов нескольких сидеров
    public function run()
    {	
    	#Контейнер зависимостей создаст экземпляр класса и вызовет у него метод
        $this->call(PostSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(CommentSeeder::class);
        // $this->call(ChanelSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(TagSeeder::class);
    }
}
