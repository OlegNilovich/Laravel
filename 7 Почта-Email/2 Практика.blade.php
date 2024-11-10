<?php

#Маршрут
Route::match(['get', 'post'],'/send', 'ContactController@send');

#Мейлер
class TestMail extends Mailable
{
	use Queueable, SerializesModels;

	public $body;

	public function __construct($body)
	{
		$this->body = $body;
	}

	public function build()
	{
		#Возвращаем вид, прикрепляем файл к письму вложенную картинку
		return $this->view('mail')->attach(url('img/1.jpg'));
	}
}

#Контроллер
class ContactController extends Controller
{
	public function send(Request $request)
	{   
		if ($request->method() == 'POST') {
			$body = "<p><b>Имя:</b>{$request->input('name')}</p>";
			$body .= "<p><b>E-mail:</b>{$request->input('email')}</p>";
			$body .= "<p><b>Сообщение:</b><br>" . nl2br($request->input('text')) . "</p>";
			Mail::to('screomy@gmail.com')->send(new TestMail($body));
			$request->session()-flash('success', 'Сообщение отправлено');
			$title = 'Send Page';
			return redirect('/send');
		} else {
			return view('send');
		}
	}
}

?>

{{-- Форма отправки письма  send.blade.php --}}
@section('content')
	<div class="container">

		<form method="post" action="/send">

			@csrf

			<div class="form-group">
				<label for="name">Your name</label>
				<input type="text" class="form-control" id="name" name="name">
			</div>

			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email">
			</div>

			<div class="form-group">
				<label for="text">Your message</label>
				<textarea class="form-control" id="text" rows="3" name="text"></textarea>
			</div>

			<button type="submit" class="btn btn-primary">Send</button>

		</form>

	</div>
@endsection

{{-- mail.blade.php --}}
<body>
	
	{{-- HTML Содержание письма --}}
	{!! $body !!}

	{{-- Прикрепляем вторую каринку к телу письма --}}
	<img src="{{ $message->embed(url('img/2.jpg')) }}" alt="">

</body>
