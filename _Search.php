<?php

#Поиск постов на сайте по заголовку

#Создаем миграцию: В таблице 'posts' добавляем индекс для поля 'title'
#Команда: php artisan make:migration change_table_posts_add_title_index --table=posts

#Добавление неуникального индекса
$table->index('title');

#Удаление неуникального индекса
$table->dropIndex('title');

#Создаем маршрут для поиска
Route::get('/search', 'SearchController@index')->name('search');

#Создаем контроллер
class SearchController extends Controller
{
    public function index(Request $request)
    {
        #Валидируем и получаем данные из строки поиска на сайте
        $request->validate([ 'search' => 'required' ]);
        $search = $request->search;

        #Получаем список постов по поиску без преминения скоупа (findByTitle)
        $posts = Post::where('title', 'LIKE', "%{$search}%")
            ->with('category')
            ->paginate(2);

        #Получаем список постов по поиску с преминением скоупа (findByTitle)
        $posts = Post::findByTitle($search)
            ->with('category')
            ->paginate(2);

        return view('posts.search', compact('posts', 'search'));
    }
}

# Добавляем гет-параметры страницы после гет-параметров поиска
# {{ $posts->appends(['search' => request()->search])->links() }}

# Гет-параметры поиска:       ?search=Природа
# Гет-параметрам страницы:    ?page=2
# Объединенные гет параметры: ?search=Природа&page=2
