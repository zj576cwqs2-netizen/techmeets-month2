<form action="/posts" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" placeholder="タイトル">
    <textarea name="body" placeholder="本文"></textarea>
    <input type="file" name="image">
    <button type="submit">投稿する</button>
</form>