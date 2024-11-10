<p>Список постов</p>

<a href="{{ route('posts.create') }}">Создать пост</a>

@foreach($posts as $post)
    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
@endforeach
