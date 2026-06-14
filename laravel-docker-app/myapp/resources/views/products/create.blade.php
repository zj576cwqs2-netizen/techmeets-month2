<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品登録</title>
</head>
<body>
    <h1>商品登録</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <p>
            <label>商品名</label><br>
            <input type="text" name="name">
        </p>

        <p>
            <label>価格</label><br>
            <input type="number" name="price">
        </p>

        <p>
            <label>カテゴリー</label><br>
            <input type="text" name="category">
        </p>

        <p>
            <label>在庫数</label><br>
            <input type="number" name="stock">
        </p>

        <p>
            <label>説明</label><br>
            <textarea name="description" rows="4"></textarea>
        </p>

        <button type="submit">登録する</button>
    </form>

    <a href="{{ route('products.index') }}">一覧に戻る</a>
</body>
</html>