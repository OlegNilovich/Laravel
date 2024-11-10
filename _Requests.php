<?php

#Мы можем создать класс-запрос для методов 'store' и 'update'
#Чтобы вынести валидационные правила в этот класс из контроллера 
#Создаем класс-запрос: php artisan make:request StoreCategoryRequest
#Не забываем импортировать класс-запрос в контроллере

#Класс-запрос для метода 'store' у контроллера 'CategoryController'
class StoreCategoryRequest extends FormRequest
{
	#Метод проверяет авторизацию пользователя и его права
    public function authorize()
    {
        return true;
    }

    #Указываем валидационные правила
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:100'
        ];
    }
}


#Класс-запрос для метода 'update' у контроллера 'CategoryController'
class UpdateCategoryRequest extends FormRequest
{
	#Метод проверяет авторизацию пользователя и его права
    public function authorize()
    {
        return true;
    }

    #Указываем валидационные правила
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:100'
        ];
    }
}
