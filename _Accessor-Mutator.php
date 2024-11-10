<?php

use Illuminate\Support\Str;

# ACCESSORS & MUTATORS - Аналог сеттеров и геттеров

# Мутатор меняет значение атребута объекта модели перед сохранением в базе данных
# Аксессор меняет значение атребута объекта модели перед отправкой пользователю

#Добавляем 2 метода в модель Пост
class Post extends Model
{
    #Метод перехватывает атребут $this->title перед сохранением его в базу
    public function setTitleAttribute($value)
    {   
        #Устанавливаем нижний регистр атребута $this->title (заголовок поста)
        $this->attributes['title'] = Str::lower($value);
    }

    #Метод перехватывает атребут $this->title перед отправкой его пользователю
    public function getTitleAttribute($value)
    {   
        #Устанавливаем верхний регистр атребута $this->title (ЗАГОЛОВОК ПОСТА)
        return Str::upper($value);
    }
}
