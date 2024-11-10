<?php

#Ресурсный Full-REST контроллер
class PostsController extends Controller
{
    public function index()
    {   
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required', 'content' => 'required']);
        Post::create($data);
        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate(['title' => 'required', 'content' => 'required']);
        $post->update($data);
        return redirect()->route('posts.show', $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}

