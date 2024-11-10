<form action="{{ route('posts.update', $post->id) }}" method="post">
    @csrf
    @method('patch')

    <div class="form-group">
        <label for="title">Заголовок поста</label>
        <input type="text" name="title" value="{{ $post->title }}">
    </div>

    <div class="form-group">
        <label for="content">Содержание поста</label>
        <textarea name="content" id="content">{{ $post->content }}</textarea>
    </div>

    <button type="submit">Обновить</button>
</form>
