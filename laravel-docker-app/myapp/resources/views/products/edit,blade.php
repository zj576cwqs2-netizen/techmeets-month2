<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品編集</title>
</head>
<body>
    <h1>商品編集</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <p>
            <label>商品名</label><br>
            <input type="text" name="name" value="{{ $product->name }}">
        </p>

        <p>
            <label>価格</label><br>
            <input type="number" name="price" value="{{ $product->price }}">
        </p>

        <p>
            <label>カテゴリー</label><br>
            <input type="text" name="category" value="{{ $product->category }}">
        </p>

        <p>
            <label>在庫数</label><br>
            <input type="number" name="stock" value="{{ $product->stock }}">
        </p>

        <p>
            <label>説明</label><br>
            <textarea name="description" rows="4">{{ $product->description }}</textarea>
        </p>

        <button type="submit">更新する</button>
    </form>

    <a href="{{ route('products.index') }}">一覧に戻る</a>
</body>
</html>