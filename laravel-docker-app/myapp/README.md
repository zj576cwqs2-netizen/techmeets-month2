<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## リファクタリング: Fat Controller の解消

### 対象
- `app/Http/Controllers/PostController.php`
- `app/Http/Controllers/TaskController.php`

### 問題点(Before)

両コントローラーとも、Service/Repository層がすでに用意されているにもかかわらず、コントローラーが以下のような責務を直接抱え込んでいた:

- Eloquentモデル(`Post`, `Task`)への直接アクセス
- バリデーション後のデータ加工(タグ同期処理など)
- ビジネスロジックとデータアクセスの混在

#### Before: PostController@index
```php
public function index()
{
    $posts = Post::latest()->paginate(10);
    return view('posts.index', compact('posts'));
}
```

#### Before: PostController@store
```php
public function store(Request $request)
{
    $post = Post::create($request->only('title', 'body'));
    $post->tags()->sync($request->tags);
    return redirect()->route('posts.index');
}
```

#### Before: TaskController(層の使い方が不統一)
`create()` / `index()` / `show()` / `destroy()` は `TaskRepository` を直接呼び出す一方、`store()` / `update()` は `TaskService` 経由と、アクセス経路が混在していた。

```php
public function __construct(
    private TaskService $taskService,
    private TaskRepository $taskRepository
){}

public function index()
{
    $tasks = $this->taskRepository->getAll(); // Repositoryを直接呼び出し
    return view('tasks_index', compact('tasks'));
}
```

### 改善後(After)

コントローラーは **Service層のみに依存**し、モデル操作・データ加工はすべてServiceとRepositoryに委譲する構成に統一した。

#### After: PostController@index
```php
public function index()
{
    $posts = $this->postService->getAllPosts();
    return view('posts.index', compact('posts'));
}
```

#### After: PostController@store
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
    ]);

    $post = $this->postService->createPost($validated);
    $this->postService->syncTags($post, $request->tags ?? []);

    return redirect()->route('posts.index');
}
```

#### After: TaskController(依存をServiceのみに統一)
```php
public function __construct(
    private TaskService $taskService
){}

public function index()
{
    $tasks = $this->taskService->getAllTasks(); // Service経由に統一
    return view('tasks_index', compact('tasks'));
}
```

### 主な変更点

| 項目 | Before | After |
|---|---|---|
| モデルへの直接アクセス | Controller内で `Post::create()` 等を直接呼び出し | Service経由(`postService->createPost()`)に統一 |
| 依存関係 | `TaskController` が `TaskService` と `TaskRepository` の両方に依存 | `TaskService` のみに依存(単一責任の原則) |
| タグ同期処理 | Controller内に直書き | `PostService::syncTags()` に切り出し |
| バリデーション | 一部項目(`user_id`)をクライアントから受け取れる不備あり | サーバー側で `Auth::id()` から自動設定するよう修正 |

### 得られた効果

- **テスト容易性の向上**: Controllerがモデルに依存しなくなったため、Serviceをモックしたユニットテストが書きやすくなった
- **責務の明確化**: Controller = リクエスト処理とレスポンス返却、Service = ビジネスロジック、Repository = データアクセス、という役割分担が徹底された
- **不整合の解消**: `TaskController` 内で発生していた「一部はRepository直接、一部はService経由」という一貫性のない依存関係を解消