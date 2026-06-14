// Create: 作成
$Product = Product::create(['title' => '商品名', 'price' => 500]);

// Read: 取得
$products =Product::where('description', '商品の説明文')->get();
$Product = Product::where('stock', '>', 10)->first();
$Product = Product::category()->where('name', 'カテゴリー名')->first();



// Update: 更新
$Product->update(['name' => '新しい商品名', 'price' => 1000]);


// Delete: 削除
$Product->delete();