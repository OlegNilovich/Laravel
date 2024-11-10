<?php 

// Eloquent ORM использует коллекцию объектов и работает в базой данных через Модель
// Он работает с каждой отдельной записью (строкой) из базы данных как с объектом
// Где свойства - названия полей, а значения свойств - значения ячеек полей

// Консольные команды
# php artisan help make:model        список опций
# php artisan make:model Post        создать модель для таблицы 'posts'
# php artisan make:model Post -m     создать модель и миграцию для таблицы 'posts'


class Post extends Model
{   
    #Устанавливаем разрешенные поля для массового присвоения
    protected $fillable = ['title', 'content'];

    #Устанавливаем запрещенные поля для массового присвоения
    protected $guarded = ['id', 'status'];

    #Если не следуем конвенции именования, то указываем имя таблицы:
    protected $table = 'my_posts';

    #Если первичный ключ таблицы не является полем 'id', то указываем поле ключа:
    protected $primaryKey = 'post_id';

    #Если первичный ключ таблицы не инкрементируется, то указываем:
    public $incrementing = false;

    #Если первичный ключ является строкой, то указываем:
    protected $keyType = 'string';

    #Отключаем автозаполнение полей 'created_at' и 'updated_at'
    public $timestamps = false;

    #Автоматическое заполнение полей
    protected $attributes = ['content' => 'Some content text'];

}

// Работаем с моделью через контроллер
class HomeController extends Controller
{
    public function index()
    {   
        # 1 способ Создания записи
        $post = new Post();
        $post->title = 'Post 1';
        $post->content = 'Content 1';
        $post->save();

        # 2 способ Создания записи с помощью массового присвоения
        $post = new Post();
        $post->fill([ 'title' => 'Post 11', 'content' => 'Content 11' ]);
        $post->save();

        # 3 способ Создания записи с помощью массового присвоения
        #Добавляем свойство в модель:  protected $fillable = ['title', 'content'];
        Post::create([ 'title' => 'Post 11', 'content' => 'Content 11' ]);

        # Получение записей
        $posts = Post::all();
        $posts = Post::find(7);
        $posts = Post::limit(5)->get();
        $posts = Post::where('id', '>', 5)->select('title')->get();

        # Изменение одной записи
        $post = Post::find(11);
        $post->title = 'Post 12';
        $post->content = 'Content 12';
        $post->save();

        # Изменение нескольких записей
        Post::where('id', '>', 5)->update(['content' => 'random text']);

        # 1 способ Удаления одной записи
        $post = Post::find(11);
        $post->delete();

        # 2 способ Удаления одной записи
        Post::destroy(10);


        // $posts = Post::all(); dd($posts);
        return view('home');
    }
}
