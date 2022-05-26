---
title: ミドルウェア
weight: 7
---

## デフォルトのミドルウェア

For checking against a single permission (see Best Practices) using `can`, you can use the built-in Laravel middleware provided by `\Illuminate\Auth\Middleware\Authorize::class` like this:

を使用して単一の権限（ベストプラクティスを参照）と照合するには、次のようcanに提供される組み込みのLaravelミドルウェアを使用できます。\Illuminate\Auth\Middleware\Authorize::class

```php
Route::group(['middleware' => ['can:publish articles']], function () {
    //
});
```

## パッケージミドルウェア

This package comes with `RoleMiddleware`, `PermissionMiddleware` and `RoleOrPermissionMiddleware` middleware. You can add them inside your `app/Http/Kernel.php` file.

このパッケージには、、およびミドルウェアが付属してRoleMiddlewareいPermissionMiddlewareますRoleOrPermissionMiddleware。ファイル内に追加できapp/Http/Kernel.phpます。

```php
protected $routeMiddleware = [
    // ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

Then you can protect your routes using middleware rules:

次に、ミドルウェアルールを使用してルートを保護できます。

```php
Route::group(['middleware' => ['role:super-admin']], function () {
    //
});

Route::group(['middleware' => ['permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role:super-admin','permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:publish articles']], function () {
    //
});
```

Alternatively, you can separate multiple roles or permission with a `|` (pipe) character:

|または、 （パイプ）文字を使用して複数の役割または権限を区切ることができます。

```php
Route::group(['middleware' => ['role:super-admin|writer']], function () {
    //
});

Route::group(['middleware' => ['permission:publish articles|edit articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
    //
});
```

You can protect your controllers similarly, by setting desired middleware in the constructor:

コンストラクターで目的のミドルウェアを設定することにより、コントローラーを同様に保護できます。

```php
public function __construct()
{
    $this->middleware(['role:super-admin','permission:publish articles|edit articles']);
}
```

```php
public function __construct()
{
    $this->middleware(['role_or_permission:super-admin|edit articles']);
}
```
