<div>
    <h3>{{ $post->id }} . {{ $post->title }}</h3>
    <p>{{ $post->content }}</p>
</div>

<div>
    <a href="{{ route('posts.edit', $post->id) }}">Редактировать</a>
</div>

<div>
    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="Удалить">
    </form>
</div>

<div>
    <a href="{{ route('posts.index') }}">Назад</a>
</div>
