<?php

# ONE TO MANY - ОДИН КО МНОГИМ
# ОДИН ПОЛЬЗОВАТЕЛЬ ИМЕЕТ МНОГО ПОСТОВ (ПОСТ ПРЕНАДЛЕЖИТ ОДНОМУ ПОЛЬЗОВАТЕЛЮ)

#Таблица для Пользователей
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

#Таблица для Постов
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('text');
    $table->timestamps();
    $table->integer('user_id')->nullable();
    $table->index('user_id', 'post_user_idx');
    $table->foreign('user_id', 'post_user_fk')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
});

#Модель пользователя
class User extends Model
{   
    public function posts()
    {   
        #      $user имеет много $posts 
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
}

#Модель комментария
class Post extends Model
{
    public function user()
    {   
        #      $posts пренадлежат $user
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

#Контроллер
class HomeController extends Controller
{
	public function index()
	{	
        #1 Способ получить посты пользователя с айди 1
        $user = User::find(1);
        $posts = Post::where('user_id', $user->id)->get();

        #2 Способ получить посты пользователя с айди 1
        $user = User::find(1);
        $user->posts;
	}
}
