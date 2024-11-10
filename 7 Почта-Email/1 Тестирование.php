<?php

#Создаем учетную запись на сайте для тестирования почты  mailtrap.io

#Настройка почты в файле .env
/*MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=61fcb415b5141d
MAIL_PASSWORD=20dc8b21216bc9
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=laravel@mail.com
MAIL_FROM_NAME="${APP_NAME}"*/

#Создаем маршрут для отправки почты
Route::get('/send', 'ContactController@send');

#Создаем контроллер: php artisan make:controller ContactController
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send()
    {   
    	#Отправляем письмо(экземпляр класса мейлер) на почту пользователю
        Mail::to('screomy@gmail.com')->send(new TestMail());

        #Подключаем вид об успешной отправке письма
        return view('send');
    }
}

#Создаем mailer-class: php artisan make:mail TestMail
class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function build()
    {	
    	#Вид письма, которое будето отправлено пользователю
        return $this->view('mail');
    }
}

?>

<!-- Вид об успешной отправке письма  send.blade.php -->
<div class="container">
	<div class="alert alert-success">
		Письмо успешно отправлено!
	</div>
</div>

<!-- Содержание пьсма, которое будет оптравлено  mail.blade.php -->
<h1>Привет. Это письмо с сайта</h1>
