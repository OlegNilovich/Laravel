<?php

#Мягкое удаление(soft delete)

#Миграция: добавляем новую колонку 'deleted_at' в таблицу 'posts'
class AddSoftdeleteToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->dropColumn('deleted_at');

        });
    }
}

#Модель: импортируем класс и добавляем трейт
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
}

#Контроллер: использование софт-делит методов
class PostController extends Controller
{
    #Получаем список всех постов вместе с софт-удаленными
    public function indexWithTrashed()
    {   
        $posts = Posts::withTrashed()->get();
    }

    #Получаем список только софт-удаленных постов
    public function indexOnlyTrashed()
    {   
        $tags = Posts::onlyTrashed()->get();
    }

    #Мягкое удаление - запись даты в колонку 'deleted_at'
    public function softDelete($id)
    {
        Posts::find($id)->delete();
    }

    #Полное удаление записи из базы данных
    public function forceDelete($id)
    {
		Posts::find($id)->forceDelete();
    }

    #Восстанавливаем софт-удаленный пост
    public function restore($id)
    {
        Posts::find($id)->restore();
    }
}
