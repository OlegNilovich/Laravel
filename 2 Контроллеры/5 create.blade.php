<form action="{{ route('posts.store') }}" method="post">
    @csrf

    <div class="form-group">
        <label for="title">Заголовок поста</label>
        <input type="text" name="title">
    </div>

    <div class="form-group">
        <label for="content">Содержание поста</label>
        <textarea name="content" id="content"></textarea>
   
		</div>

		<button type="submit">Submit</button>
</form>
