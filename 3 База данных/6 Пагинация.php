<?php

#Пагинация: вывод задонного количества записей на одной странице

#Чтобы поменять стиль пагинации, нужно:
#Копируем шаблоны пагинации: php artisan vendor:publish --tag=laravel-pagination
#В папке появятся разные стили пагинации resources/views/vendor/paginaton

class HomeController extends Controller
{
	public function index(Request $request)
	{	
		#Выводить по (6) постов на странице
		$posts = Post::orderBy('id', 'desc')->paginate(6);
		return view('home', compact('posts'));
	}
}

?>

<!--Добавляем отображение списка ссылок в виде home.blade.php -->
<!-- http://larawfm/?page=2 -->
<div class="col-md-12">
	{{ $posts->links() }}
</div>

<!-- Сохраняем передаваемые нами ГЕТ-параметры  -->
<!-- http://larawfm/?test=123&page=2 -->
<div class="col-md-12">
	{{ $posts->appends(['test' => request()->test])->links() }}
</div>

<!-- Подключаем разные стили пагинации из папки  views/vendor/pagination -->
<div class="col-md-12">
	{{ $posts->links('vendor.pagination.default') }}
	{{ $posts->links('vendor.pagination.bootstrap-4') }}
	{{ $posts->links('vendor.pagination.semantic-ui') }}
	{{ $posts->links('vendor.pagination.tailwind') }}
</div>
