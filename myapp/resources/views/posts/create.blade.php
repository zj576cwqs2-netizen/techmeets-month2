<form action="/posts" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title">
    <textarea name="body"></textarea>
    <input type="file" name="image">
    <button type="submit">投稿</button>
</form>
