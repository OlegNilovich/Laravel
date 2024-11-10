<?php

# Модели

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{   
    #Использование трейна Слаг
    use Sluggable;

    #Поля допустимые для заполнения
    protected $fillable = ['title', 'description', 'content', 'category_id', 'thumbnail'];

    #Связь с тегами
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    #Связь с категорией
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    #Генерация слага
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    #Загрузка изображения, переданного из формы создания или изменения поста
    public static function uploadImage(Request $request, $image = null)
    {   
        #Если в запросе пришел файл-картинка
        if ($request->hasFile('thumbnail')) {
            #Если вторым аргументом был передан путь до картинки
            if ($image) {                     
                #Тогда удаляем старую картинку из хранилища
                Storage::delete($image);      
            }
            #Создаем папку с текущей датой
            $folder = date('Y-m-d');
            #Cохраняем картинку в эту папку и возвращаем путь до картинки
            return $request->file('thumbnail')->store("images/{$folder}");
        }
        #Если в запросе нет файла-картинки - возвращаем NULL
        return null;
    }

    #Получение пути к картинке текущего поста, если она есть
    #Иначе вернется путь к картинке-заглушке 'no-image.png'
    public function getImage()
    {   
        if ($this->thumbnail) {
            return asset("uploads/{$this->thumbnail}");
        }
        return asset("no-image.png");
    }

    #Отображение даты поста    
    public function getPostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->format('d F, Y');
    }

    #Скоуп: Поиск поста по заголовку
    public function scopeFindByTitle($query, $search)
    {
        return $query->where('title', 'LIKE', "%{$search}%");
    }
}


class Category extends Model
{   
    #Использование трейта Слаг
    use Sluggable;

    #Поля допустимые для заполнения
    protected $fillable = ['title'];

    #Связь с постами
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    #Генерация слага
    public function sluggable(): array
    {   
        return [ 'slug' => [ 'source' => 'title' ] ];
    }
}


class Tag extends Model
{   
    #Использование трейта Слаг
    use Sluggable;

    #Поля допустимые для заполнения
    protected $fillable = ['title'];

    #Связь с постами
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    #Генерация слага
    public function sluggable(): array
    {   
        return [ 'slug' => [ 'source' => 'title' ] ];
    }

}

