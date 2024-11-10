<?php

#ТРАНЗАКЦИИ - позволяют выполнять блок из нескольких запросов в базу данных
#В случае ошибки хотя бы в одном из запросов - отменяет весь блок запросов

DB::beginTransaction(); #Начало транзакции
try {
	#Пытаемся выполнить блок из нескольких запросов в базу данных
} catch (Exception $e) {
	DB::rollback(); #Откатываем весь блок в случае неудачи в одном из запросов
}


#Пример
class HomeController extends Controller
{
	public function index()
	{
		#Начало транзакции
		DB::beginTransaction();

		#Пытаемся выполнить два запроса в базу данных
		try {
			#Специально допускаем в перво запросе ошибку '123' в названии поля 'title'
			DB::update("UPDATE posts SET title123 = ? WHERE id = 5", ["Пост 6"]);
			DB::update("UPDATE posts SET content = ? WHERE id = 5", ["Контент 6"]);

		#В случае ошибки делаем откат запросов и выводим ошибку
		} catch (\Exception $e) {
			DB::rollback();
			echo $e->getMessage();
		}
	}
}

#Ошибка:  SQLSTATE[42S22]: Column not found: 1054 Unknown column 'title123' in 'field list' (SQL: UPDATE posts SET title123 = Пост 6 WHERE id = 5)
