<?php

#АВТОРИЗАЦИЯ ПОЛЬЗОВАТЕЛЯ
#В AppServiseProvider отключить DB::listen(function ($query) {dump($query->sql);});


#Маршруты
Route::get('/login', 'UserController@loginForm')->name('login.create');
Route::post('/login', 'UserController@login')->name('login');
Route::get('/logout', 'UserController@logout')->name('logout');

#Контроллер
class UserController extends Controller
{
	public function create()
	{
		return view('user.create');
	}

	public function store(Request $request)
	{   
		#Валдация данных регистрации пользователя
		$request->validate([
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed',
		]);

		#Создание нового пользователя
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

	#Показ формы авторизации(логина)
	public function loginForm()
	{
		return view('user.login');
	}

	#Авторизация(логин)
	public function login(Request $request)
	{
		#Валидация данных логина
		$request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		#Авторизация пользователя
		if (Auth::attempt([
			'email' => $request->email,
			'password' => $request->password
		])) {
			#Если успешно - редирект на главную
			return redirect()->home;
		}
		#Если неудачно - редирект на форму авторизации с ошибкой
		return redirect()->back()->with('error', 'Неправильный логин или пароль');
	}

	#Логаут
	public function logout()
	{
		Auth::logout();
		return redirect()->route('login.create');
	}
}

?>

<!-- Форма авторизации пользователя login.blade.php -->
@section('content')
	<div class="container">

		<form method="post" action="{{ route('register.store') }}">

			@csrf

			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>
			
			<button type="submit" class="btn btn-primary">Register</button>

		</form>

	</div>
@endsection

<!-- 1 вариант: Отображение ссылок для пользователя layout.blade.php -->
@if(auth()->check())
	<a href="#" class="text-white">{{ auth()->user()->name }}</a>
	<a href="{{ route('logout') }}" class="text-white">Logout</a>
@else
	<a href="{{ route('register.create') }}" class="text-white">Register</a>
	<a href="{{ route('login.create') }}" class="text-white">Login</a>
@endif

{{-- 2 вариант: Показ ссылок для пользователя layout.blade.php--}}
@auth
	<a href="#" class="text-white">{{ auth()->user()->name }}</a>
	<a href="{{ route('logout') }}" class="text-white">Logout</a>
@endauth

@guest
	<a href="{{ route('register.create') }}" class="text-white">Register</a>
	<a href="{{ route('login.create') }}" class="text-white">Login</a>
@endguest

<!-- Флеш-сообщение о неудачной авторизации alerts.blade.php -->
@if(session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif
