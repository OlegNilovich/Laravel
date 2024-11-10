
{{-- Добавляем дополнительный метод для формы --}}
1 способ:  <input type="hidden" name="_method" value="PUT">
2 способ:  {{ method_field('PUT') }}
3 способ:  @method('PUT')

{{-- Добавляем csrf-токен для защиты формы от подмены данных --}}
1 способ:  <input type="hidden" name="_token" value="{{ csrf_token() }}">
2 способ:  {{ csrf_field() }}
3 способ:  @csrf

{{-- Пример формы для редактирования поста --}}
<form action="/post/edit" method="post">
	@csrf
	@method('PUT')
	<input type="text" name="title">
	<textarea name="content"></textarea>
	<button	type="submit">Submit</button>
</form>
