<?php

#ДОБАВЛЕНИЕ АВАТАРКИ ПРИ РЕГИСТРАЦИИ ПОЛЬЗОВАТЕЛЯ

#В файле .env добавляем строку: FILESYSTEM_DRIVER=public
#Каждая аватарка будет сохраняться в папке с именем текущей даты, пример:
//storage/app/public/images/2023-05-21/gAl1h2qxVhTPyAny5y8UUFzdePx6lR0LIsBrUMFu.png

#ОТОБРАЖЕНИЕ АВАТАРКИ ПОЛЬЗОВАТЕЛЯ
#Создаем символическую ссылку(ярлык): php artisan storage:link
#Для соединения папки с публичным доступом public/storage
#С папкой с закрытым доступом, где хранятся аватарки storage/app/public

#Миграция: php artisan make:migration add_avatar_to_users --table=users
class AddAvatarToUsers extends Migration
{
	public function up()
	{
		#Добавляем поле, где будет храниться путь до аватарки
		Schema::table('users', function (Blueprint $table) {
			$table->string('avatar')->nullable();
		});
	}

	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('avatar');
		});
	}
}

#Добавляем в модель User свойство 'avatar' для массового присваивания
class User extends Authenticatable
{
    protected $fillable = [
        'avatar',
    ];
}

#Контроллер
class UserController extends Controller
{	
    public function store(Request $request)
    {   
				#Добавляем валидацию Аватарки
        $request->validate([
            'avatar' => 'nullable|image',
        ]);

        #Если пользователь отправил аватарку в форме регистрации
        if ($request->hasFile('avatar')) {

        		#Cоздаем папку с именем текущей даты и сохраняем в неё Аватарку
            $folder = date('Y-m-d');
            $avatar = $request->file('avatar')->store("images/{$folder}");
        }

        #Если пользователь отправил аватарку в форме регистрации
        $user = User::create([

        		#Тогда записываем путь до аватарки в поле 'avatar', либо null
            'avatar' => $avatar ?? null,
        ]);
    }
}

?>

<!-- Добавляем дополнительный параметр для формы  user/create.blade.php -->
<form enctype="multipart/form-data">

<!-- Добавляем новое поле для загрузки аватарки  user/create.blade.php -->
<div class="form-group">
	<label for="avatar">Avatar</label>
	<input type="file" class="form-control-file" id="avatar" name="avatar">
</div>

<!-- Добавляем отображение аватарки рядом с именем пользователя -->
<a href="#" class="text-white">
    @if(auth()->user()->avatar)
        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="" height="40">
    @endif
    {{ auth()->user()->name }}
</a>
