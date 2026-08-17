<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品詳細</title>
</head>
<body>
    <h1>商品詳細</h1>

    <p>商品名: {{ $product->name }}</p>
    <p>カテゴリー: {{ $product->category }}</p>
    <p>価格: {{ $product->price }}円</p>
    <p>在庫数: {{ $product->stock }}</p>
    <p>説明: {{ $product->description }}</p>

    <a href="{{ route('products.edit', $product->id) }}">編集</a>
    <a href="{{ route('products.index') }}">一覧に戻る</a>
</body>
</html>