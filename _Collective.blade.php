-
<!-- Пакет для форм (устаревший) -->

Установка: composer require "laravelcollective/html"

Прописываем в файле  config/app.php 

'providers' => [
    Collective\Html\HtmlServiceProvider::class,

'aliases' => [
    'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class,


<!-- Обычная форма -->
<form method="POST" action="{{ route('submit.form') }}">
    @csrf
    <label for="name">Name:</label>
    <input type="text" name="name" id="name">

    <label for="email">Email:</label>
    <input type="email" name="email" id="email">

    <button type="submit">Submit</button>
</form>
<!-- Форма Laravel-Collective -->
{!! Form::open(['route' => 'submit.form']) !!}

    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name') !!}

    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email') !!}

    {!! Form::submit('Submit') !!}

{!! Form::close() !!}
