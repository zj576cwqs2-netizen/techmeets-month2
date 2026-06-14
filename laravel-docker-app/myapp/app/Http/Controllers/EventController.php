// Create: 作成
$Event = Event::create(['name' => 'イベント名', 'description' => 'イベントの説明文', 'date' => '2023-12-31'
]);

// Read: 取得
$events =Event::where('description', 'イベントの説明文')->get();
$Event = Event::where('date', '>', '2023-12-31')->first();
$Event = Event::category()->where('name', 'カテゴリー名')->first();



// Update: 更新
$Event->update(['name' => '新しいイベント名', 'description' => '新しいイベントの説明文']);


// Delete: 削除
$Event->delete();