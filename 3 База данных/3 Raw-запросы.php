<?php

// Использование сырых SQL-запросов к бд 
class HomeController extends Controller
{
    public function index()
    {
        $query = DB::insert("INSERT INTO posts (title, content) 
            values (?, ?)", ['Пост 5', 'Контент 5']);

        DB::update("UPDATE posts SET title = ?, content = ? WHERE id = 5", ["Пост пять", "Контент пять"]);

        DB::delete("DELETE FROM posts WHERE id = ?", [5]);

        $posts = DB::select("SELECT * FROM posts WHERE id > :id", ['id' => 2]);
        return $posts;

    }
}

// При каждом запросе в бд мы можем отследить SQL-код запроса и привязки
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        DB::listen(function ($query) {
            dump($query->sql, $query->bindings);
        });
    }
}
