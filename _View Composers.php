<?php

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        #Отображение имени Администратора в базовом шаблоне админки
        view()->composer('admin.layouts.layout', function ($view) {
            $adminName = Auth::user()->name ?? null;
            $view->with('adminName', $adminName);
        });

        #Передача данных в шаблон-сайдбар
        view()->composer('layouts.sidebar', function ($view) {
            
            #1 Отображение популярных постов
            $popular_posts = Post::orderBy('views', 'desc')->limit(3)->get();
            $view->with('popular_posts', $popular_posts);

            #2 Отображение категорий с количеством постов в них
            $cats = Category::withCount('posts')->orderBy('posts_count','desc')->get();
            $view->with('cats', $cats);

            #3 Отображение тегов с количеством постов в них
            $tags = Tag::withCount('posts')->orderBy('posts_count','desc')->get();
            $view->with('tags', $tags);


            #1 Отображение популярных постов (кеш на 60 секунд)
            if (Cache::has('popular_posts')) {
                $popular_posts = Cache::get('popular_posts');
            } else {
                $popular_posts = Post::orderBy('views', 'desc')->limit(3)->get();
                Cache::put('popular_posts', $popular_posts, 60);
            }
            $view->with('popular_posts', $popular_posts);

            #2 Отображение категорий с количеством постов в них (кеш на 60 секунд)
            if (Cache::has('cats')) {
                $cats = Cache::get('cats');
            } else {
                $cats = Category::withCount('posts')->orderBy('posts_count','desc')->get();
                Cache::put('cats', $cats, 60);
            }
            $view->with('cats', $cats);

            #3 Отображение тегов с количеством постов в них (кеш на 60 секунд)
            if (Cache::has('tags')) {
                $tags = Cache::get('tags');
            } else {
                $tags = Category::withCount('posts')->orderBy('posts_count','desc')->get();
                Cache::put('tags', $tags, 60);
            }
            $view->with('tags', $tags);
        });
    }
}

