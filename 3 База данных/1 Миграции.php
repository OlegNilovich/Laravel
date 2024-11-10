<?php

#Для изменения таблиц требуется установка:  composer require doctrine/dbal
#Если не работает миграция: composer update  и  composer dump-autoload
#Для Laravel 7 требуется версия "doctrine/dbal": "^2.0"

#  to_posts  в команде создания миграции указывает на таблицу 'posts'
#Флаг --table=posts нужен если не следовать конвенции именования миграции

#Создать модель и миграцию
php artisan make:model Post -m

#Создание таблицы
php artisan make:migration create_posts_table

#Удаление таблицы
php artisan make:migration delete_posts_table

#Создание таблицы для связи Many to Many
php artisan make:migration create_post_tag_table

#Добавление новой колонки
php artisan make:migration add_description_column_to_posts_table

#Удаление колонки
php artisan make:migration delete_description_column_to_posts_table

#Измененме название колонки
php artisan make:migration edit_name_of_description_column_to_posts_table

#Измененме типа колонки
php artisan make:migration edit_type_of_description_column_to_posts_table

#Запуск миграции(миграций)
php artisan migrate

#Откат последней миграции(миграций)
php artisan migrate:rollback

#Откат всех миграций
php artisan migrate:reset

#Откат всех миграций с последующим запуском
php artisan migrate:fresh

#Создание таблицы 'posts'
class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

#Удаление таблицы 'posts'
class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('posts');
    }

    public function down()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }
}

#Добавление новой колонки 'description' в таблицу 'posts'
class AddDescriptionColumnToPostsTable extends Migration
{	
	public function up()
	{
		Schema::table('posts', function (Blueprint $table) {
            #Добавление клоноки 'description' после колонки 'content'
            $table->text('description')->after('content')->nullable();
		});
	}

	public function down()
	{
		Schema::table('posts', function (Blueprint $table) {
            #Удаление клоноки 'description'
            $table->dropColumn('description');
		});
	}
}

#Удаление колонки 'description' из таблицы 'posts'
class DeleteDescriptionColumnToPostsTable extends Migration
{   
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            #Удаление клоноки 'description'
            $table->dropColumn('description');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            #Возврат клоноки 'description' после колонки 'content'
            $table->text('description')->after('content')->nullable();
        });
    }
}

#Изменение названия колонки 'description' в таблицу 'posts'
class EditNameOfDescriptionColumnToPostsTable extends Migration
{   
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            #Переименование клоноки 'description' на 'post_description'
            $table->renameColumn('description', 'post_description');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            #Возврат прошлого имени 'description'
            $table->renameColumn('post_description', 'description');
        });
    }
}

#Изменение типа колонки 'description' в таблице 'posts'
class EditTypeOfDescriptionColumnToPostsTable extends Migration
{   
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            #Изменение типа клоноки 'description' на 'string'
            $table->string('description')->change();
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            #Возврат прошлого типа колонки 'description' на 'text'
            $table->text('description')->change();
        });
    }
}


// ПРАКТИКА  ///////////////////////////////////////////////////////////////////////

# Добавляем в миграцию создание поля 'is_admin'
Schema::create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('email')->unique();
    $table->tinyInteger('is_admin')->default(0);
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

# Создаем модель Post и миграцию: php artisan make:model Post -m
Schema::create('posts', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->index('title');
    $table->string('slug')->unique();
    $table->text('description');
    $table->text('content');
    $table->integer('category_id')->unsigned();
    $table->integer('views')->unsigned()->default(0);
    $table->string('thumbnail')->nullable();
    $table->timestamps();
});

# Создаем модель Category и миграцию: php artisan make:model Category -m
Schema::create('categories', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->string('slug')->unique();
    $table->timestamps();
});

# Создаем модель Tag и миграцию: php artisan make:model Tag -m
Schema::create('tags', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->string('slug')->unique();
    $table->timestamps();
});

# Создаем миграцию таблицы Пост-Тэг: php artisan make:migration create_post_tag_table
Schema::create('post_tag', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('tag_id')->unsigned();
    $table->integer('post_id')->unsigned();
    $table->timestamps();
});


