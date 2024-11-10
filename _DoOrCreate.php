<?php

#Метод возвращает запись по заданному атребуту, либо создает новую запись
class PostController extends Controller
{
    public function firstOrCreate()
				{	
        $tag = Post::firstOrCreate(

									#Если есть запись с заголовком 'Первый пост' - вернуть её
        	['title' => 'Первый пост'],

        	#Иначе создать новую запись с заданными атребутами
        	['title' => 'Первый пост', 'content' => 'Первый контент']

        );
				}

    public function updateOrCreate()
				{	
        $tag = Post::updateOrCreate(

									#Если есть запись с заголовком 'Первый пост' - обновить её
        	['title' => 'Первый пост'],

        	#Иначе создать новую запись с заданными атребутами
        	['title' => 'Первый пост', 'content' => 'Первый контент']

        );
				}
}
