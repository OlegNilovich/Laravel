<?php

#РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ
#В AppServiseProvider отключить DB::listen(function ($query) {dump($query->sql);});


#Маршруты
Route::get('/register', 'UserController@create')->name('register.create');
Route::post('/register', 'UserController@store')->name('register.store');

#Миграция
class CreateUsersTable extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('users');
	}
}

#Модель
class User extends Authenticatable
{
	use Notifiable;

	protected $fillable = [
		'name', 'email', 'password',
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
	];
}

#Контроллер
class UserController extends Controller
{
	public function create()
	{
		return view('user.create');
	}

	public function store(Request $request)
	{   
		#Валидируем данные пользователя из формы
		$request->validate([
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed',
		]);

		#Создаем нового пользователя
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);

		#Флеш-сообщение, логиним пользователя, редиректим на главную
		session()->flash('success', 'Успешная регистрация');
		Auth::login($user);
		return redirect()->home();
	}
}

?>

<!-- Форма регистрации пользователя create.blade.php -->
@section('content')
	<div class="container">

		<form method="post" action="{{ route('register.store') }}">

			@csrf

			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
			</div>

			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>

			<div class="form-group">
				<label for="password_confirmation">Confirm Password</label>
				<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
			</div>

			<button type="submit" class="btn btn-primary">Register</button>

		</form>

	</div>
@endsection

<!-- Проверка логина пользователя layout.blade.php -->
@php
    dump(Auth::check());
@endphp
