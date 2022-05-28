---
title: ミドルウェア
weight: 7
---

## デフォルトのミドルウェア

<!-- For checking against a single permission (see Best Practices) using `can`, you can use the built-in Laravel middleware provided by `\Illuminate\Auth\Middleware\Authorize::class` like this: -->

`can` を使用して、単一の権限（ベストプラクティスを参照）と照合するには、以下のように、`\Illuminate\Auth\Middleware\Authorize::class` によって提供されている、組み込みの Laravel ミドルウェアを使用できます。

```php
Route::group(['middleware' => ['can:publish articles']], function () {
    //
});
```

## パッケージミドルウェア

<!-- This package comes with `RoleMiddleware`, `PermissionMiddleware` and `RoleOrPermissionMiddleware` middleware. You can add them inside your `app/Http/Kernel.php` file. -->

このパッケージには、`RoleMiddleware`, `PermissionMiddleware` 及び `RoleOrPermissionMiddleware` ミドルウェアが付属します。それらのミドルウェアを追加する際は、`app/Http/Kernel.php` ファイル内で追加できます。

```php
protected $routeMiddleware = [
    // ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

<!-- Then you can protect your routes using middleware rules: -->

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

<!-- Alternatively, you can separate multiple roles or permission with a `|` (pipe) character: -->

|（パイプ）文字を使用して、複数の役割 (Role) または権限を区切ることができます。

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

<!-- You can protect your controllers similarly, by setting desired middleware in the constructor: -->

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
