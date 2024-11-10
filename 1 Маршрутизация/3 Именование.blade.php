<?php

// ПЕРВАЯ ПРОБЛЕМА: Мы хотим поменять маршрут с /contact на /contact2
Route::match(['get', 'post'], '/contact2', function() {
    return view('contact');
});

?>

<!-- Нам так же придется менять экшен формы с /contact на /contact2  -->
<form action="/contact2" method="post">
	@csrf
	<input type="text" name="name">
	<input type="email" name="email">
	<button	type="submit">Submit</button>
</form>

<?php

// РЕШЕНИЕ: Добавляем в конце роута имя ->name('псевдоним');
Route::match(['get', 'post'], '/contact2', function() {
    return view('contact');
})->name('contact');

?>

{{-- Меняем экшен формы на {{ route('contact') }} --}}
<form action="{{ route('contact') }}" method="post">
	@csrf
	<input type="text" name="name">
	<input type="email" name="email">
	<button	type="submit">Submit</button>
</form>

{{-- Ларавель сам подставит адрес роута таким образом --}}
<form action="http://laravel.loc/contact2" method="post">

________________________________________________________________________________
________________________________________________________________________________
<?php

// ВТОРАЯ ПРОБЛЕМА: Мы хотим использовать два маршрута с одинаковыми именами

// Первый маршрут с именем 'post'
Route::get('/post/{id}/{slug?}', function($id, $slug = null) {
    return "Обязательный параметр: $id | Необязательный параметр: $slug";
})->name('post');

// Группа маршрутов с именем 'admin.'
Route::prefix('admin')->name('admin.')->group(function() {

    Route::get('/posts', function() {
        return 'Posts list';
    });

    Route::get('/post/create', function() {
        return 'Post create';
    });

	// Второй маршрут изменил имя с 'post' на 'admin.post'
    Route::get('/post/{id}/edit', function($id) {
        return "Edit post with id: $id";
    })->name('post');
}); 

?>

{{-- Теперь не будет путаницы из-за одинаковых имен маршрутов --}}
{{ route('post', ['id' => 3, 'slug' => 'test-2']) }}
{{ route('admin.post', ['id' => 3]) }}
