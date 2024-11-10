<?php

#Валидация данных формы (3 способа)
#Отображение ошибок валидации единым блоком $errors->all()
#Сохранение заполненных полей после ошибки валидации {{ old('title') }}

# Третий Способ валидации
# В файле app/config/app.php устанавливаем локализацию 'locale' => 'ru'
# Копируем файл resourses/lang/en/validation.php
# В папку resourses/lang/ru/validation.php
# Переводим текст ошибок на русский

#Импортируем класс валидатора для 2 способа валидации
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
	#Выводим форму для создания поста, передаем данные категорий в вид
	public function create()
	{   
		$title = 'Create Post';
		$categories = Category::pluck('title', 'id')->all();    #Метод класса Model
		return view('create', compact('title', 'categories'));  #Глобал функция хелпер
	}

	#Принимаем данные формы, валидируем, создаем запись в базе данных
	public function store(Request $request)
	{   
		# 1 способ валидации (текст ошибок на английском)
		$this->validate($request, [
			'title' => 'required|min:5|max:100',
			'content' => 'required',
			'category_id' => 'integer',
		]);

		# 2 способ валидации (текст ошибок задаем самостоятельно)
		$rules = [
			'title' => 'required|min:5|max:100',
			'content' => 'required',
			'category_id' => 'integer',
		];

		$messages = [
			'title.required' => 'Заполните поле Title',
			'title.min' => 'Требуется минимум 5 символов в поле Title',
			'title.max' => 'Превышено максимальное количество символов',
			'content.required' => 'Заполните поле Content',
			'category_id.integer' => 'Выберите категорию',
		];

		$validator = Validator::make($request->all(), $rules, $messages)->validate();

		#Создаем запись в базе данных
		Post::create($request->all());
		return redirect()->route('home');
	}
}

?>

{{-- 1 способ: Отображение конкретной ошибки валидации для каждого поля формы --}}
{{-- Добавляем класс для каждого поля ввода --}}
<input class="form-control @error('title') is-invalid @enderror">
{{-- Под каждым полем ввода размещаем блок @error ... @enderror --}}
@error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror

{{-- 2 способ: Отображение всех ошибок валидации формы единым блоком--}}
<div class="mt-5">
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
</div>

{{-- Форма создания поста--}}
<form class="mt-5" method="post" action="{{ route('posts.store') }}">

	@csrf

		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Title" name="title" value="{{ old('title') }}">
			@error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
		</div>

		<div class="form-group">
			<label for="content">Content</label>
			<textarea class="form-control @error('content') is-invalid @enderror" id="content" rows="5" name="content" placeholder="Content">{{ old('content') }}</textarea>
			@error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
		</div>

		<div class="form-group">
			<label for="category_id">Category</label>
			<select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
				<option>Выбор категории</option>
				@foreach($categories as $k => $v)
				 <option value="{{ $k }}" {{ old('category_id') == $k ? 'selected' : '' }}>{{ $v }}</option>
				@endforeach
			</select>
			@error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
		</div>

		<button type="submit" class="btn btn-primary">Создать</button>

	</form>
</div>
