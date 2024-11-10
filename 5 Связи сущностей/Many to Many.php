<?php

# MANY TO MANY - МНОГИЕ КО МНОГИМ
# Посты имеют много тегов. Теги имеют много постов

#Таблица для Постов
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->timestamps();
});

#Таблица для Тегов
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->timestamps();
});

#Связующая 'pivot' таблица Постов с Тегами
Schema::create('post_tag', function (Blueprint $table) {
    $table->id();

    $table->integer('post_id');
    $table->index('post_id', 'post_tag_post_idx');
    $table->foreign('post_id', 'post_tag_post_fk')->references('id')->on('posts')->onDelete('cascade');

    $table->integer('tag_id');
    $table->index('tag_id', 'post_tag_tag_idx');
    $table->foreign('tag_id', 'post_tag_tag_fk')->references('id')->on('tags')->onDelete('cascade');

    $table->timestamps();
});


#Модель поста
class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
}

#Модель тега
class Tag extends Model
{
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }
}

#Контроллер
class HomeController extends Controller
{
    public function index()
    {
        $post = Post::find(1);       #Находим объект поста с id=1
        dump($post->title);          #Выводим заголовок поста
        $tags = $post->tags;         #Получаем коллекцию тегов поста
        
        foreach ($tags as $tag) {    #Выводим название каждого тега поста в цикле
            dump($tag->title);
        }


        $tag = Tag::find(1);          #Находим объект тега с id=1
        dump($tag->title);            #Выводим название тега
        $posts = $tag->posts;         #Получаем коллекцию постов тега
        
        foreach ($posts as $post) {   #Выводим название каждого поста тега в цикле
            dump($post->title);
        }
    }
}
