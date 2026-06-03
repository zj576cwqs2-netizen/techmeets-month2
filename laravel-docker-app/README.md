Laravelアプリ　セットアップ手順
①Dockerfileの作成
②defalut.confの作成
3 docker-compose.ymlの作成
④コンテナの起動
5 Laravelのインストール
5-①　hown -R www-data:www-data storage bootstrap/cache: storage と bootstrap/cache フォルダの所有者を www-dataに変更
hmod -R 775 storage bootstrap/cache: 書き込み権限の付与
.envファイルの編集　
マイグレーションの実行
ブラウザにて確認