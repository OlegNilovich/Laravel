<?php

// Группировка и добавление префикса 'admin' к маршрутам
Route::prefix('admin')->group(function() {
    #http://laravel.loc/admin/posts
    Route::get('/posts', function() {
        return 'Posts list';
    });
    #http://laravel.loc/admin/post/create
    Route::get('/post/create', function() {
        return 'Post create';
    });
    #http://laravel.loc/admin/123/edit
    Route::get('/post/{id}/edit', function($id) {
        return "Edit post with id: $id";
    });
});
