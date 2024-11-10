<?php

# ЖАДНАЯ ЗАГРУЗКА СВЯЗАННЫХ ДАННЫХ (Загрузка всех связанных данных за один запрос)
# Низкая нагрузка на базу данных. Один запрос перед началом цикла
class HomeController extends Controller
{
    public function index()
    {
        $comments = Comment::with('person')->where('id', '>', 1)->get();

        foreach ($comments as $comment) {
            dump ($comment->person->name);
        }
    }
}

# ЛЕНИВАЯ ЗАГРУЗКА СВЯЗАННЫХ ДАННЫХ (Загрузка данных в момент обращения к свойству)
# Высокая нагрузка на базу данных. Запрос на каждой итерации цикла
class HomeController extends Controller
{
    public function index()
    {
        $comments = Comment::where('id', '>', 1)->get();

        foreach ($comments as $comment) {
            dump ($comment->person->name);
        }
    }
}

