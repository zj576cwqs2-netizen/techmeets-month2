<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
</head>
<body>
    <h1>商品一覧</h1>

    <p><a href="{{ route('products.create') }}">新規登録</a></p>

    <table border="1" cellpadding="8">
        <tr>
            <th>商品名</th>
            <th>カテゴリー</th>
            <th>価格</th>
            <th>在庫数</th>
            <th></th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->price }}円</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.show', $product->id) }}">詳細</a>
                <a href="{{ route('products.edit', $product->id) }}">編集</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('削除しますか?')">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>