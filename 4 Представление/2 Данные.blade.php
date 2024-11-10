<?php

#Передача данных в шаблонах блейд
public function index()
{   
	$title = 'Home Page';         #    {{ $title }}
	$hello = "<h1> Hello </h1>";  #    {!! $hello !!}

	$data1 = ['a', 'b', 'c', 'd', 'f'];
	$data2 = ['name' => 'Bob', 'color' => 'red', 'age' => 30];

	return view('home', compact('title', 'hello', 'data1', 'data2'));
} 

?>

@{{ Экранирование для джаваскрипт }}

{{-- Условия IF ELSE --}}
@if(count($data1) > 5)
	Количество эллементов больше 5
@elseif(count($data1) < 5)
	Количество эллементов меньше 5
@else
	Колличество эллементов равно 5
@endif

{{-- Цикл FOREACH --}}
@foreach($data2 as $k => $v)
{{ $k }} => {{ $v }} <br>
@endforeach

{{-- Цикл FOR --}}
@for($i = 0; $i < count($data1); $i++)
	@if($data1[$i] === 'c')
		@continue
	@endif
	{{ $data1[$i] }}
@endfor

{{-- Isset --}}
@isset($data2)
	Переменная data2 существует
@endisset

{{-- Production --}}
@production
  Сайт в среде продакшн
@endproduction

{{-- Local --}}
@env('local')
  Сайт в среде разработки
@endenv
