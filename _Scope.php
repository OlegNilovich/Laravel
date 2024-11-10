<?php

/*
Скоупы в моделях Laravel используются для создания более конкретных и часто 
используемых запросов. Они позволяют скрыть сложность запросов, связанных с 
фильтрацией, сортировкой или другими условиями, внутри модели.
*/

#Добавляем метод-скоуп в модель Пост
class Post extends Model
{	
				#Поиск записей по подстроке в заголовах статей
				#Второй аргумент - строка, введенная в поле поиска
    public function scopeFindByTitle($query, $search)
    {
        return $query->where('title', 'LIKE', "%{$search}%");
    }
}

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([ 'search' => 'required' ]);
        $search = $request->search;

        #Без скоупа
        // $posts = Post::where('title', 'LIKE', "%{$search}%")
        //     ->with('category')
        //     ->paginate(2);

        #Со скоупом
        $posts = Post::findByTitle($search)->with('category')->paginate(2);

        return view('posts.search', compact('posts', 'search'));
    }
}
