<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {   
        #Валидируем и получаем данные из строки поиска на сайте
        $request->validate([ 'search' => 'required' ]);
        $search = $request->search;

        #Получаем список постов по поиску без преминения скоупа (findByTitle)
        // $posts = Post::where('title', 'LIKE', "%{$search}%")
        //     ->with('category')
        //     ->paginate(2);

        #Получаем список постов по поиску с преминением скоупа (findByTitle)
        $posts = Post::findByTitle($search)
            ->with('category')
            ->paginate(2);

        return view('posts.search', compact('posts', 'search'));
    }
}
