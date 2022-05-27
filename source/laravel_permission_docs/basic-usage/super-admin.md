---
title: スーパー管理者の定義
weight: 5
---

<!-- We strongly recommend that a Super-Admin be handled by setting a global `Gate::before` or `Gate::after` rule which checks for the desired role. -->

<!-- Then you can implement the best-practice of primarily using permission-based controls (@can and $user->can, etc) throughout your app, without always having to check for "is this a super-admin" everywhere. Best not to use role-checking (ie: `hasRole`) when you have Super Admin features like this. -->

スーパー管理者は、目的の役割 (Role) をチェックするグローバルな `Gate::before` と `Gate::after` のルールを設定して処理することを強くお勧めします。

次に、アプリ全体で主に権限 (Permission) ベースのコントロール （ `@can` や `$user->can` など）を使用するベストプラクティスを実装できます。常に「これはスーパー管理者ですか」をどこでもチェックする必要はありません。 このようなスーパー管理機能がある場合は、ロールチェック（例えば、`hasRole` ) を使用しないことをお勧めします。

## `Gate::before`

<!-- If you want a "Super Admin" role to respond `true` to all permissions, without needing to assign all those permissions to a role, you can use Laravel's `Gate::before()` method. For example: -->

もしあなたが、すべての権限 (Permission) に対して、「スーパー管理者」の役割 (Role) の返答として `true`  のレスポンスを返したい場合は、それらのすべての権限 (Permission) を役割 (Role) に割り当てる必要はなく、Laravelの`Gate::before()` 方法を使用できます。例えば：

```php
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
```

<!-- NOTE: `Gate::before` rules need to return `null` rather than `false`, else it will interfere with normal policy operation. [See more.](https://laracasts.com/discuss/channels/laravel/policy-gets-never-called#reply=492526) -->

<!-- Jeffrey Way explains the concept of a super-admin (and a model owner, and model policies) in the [Laravel 6 Authorization Filters](https://laracasts.com/series/laravel-6-from-scratch/episodes/51) video and some related lessons in that chapter. -->

注：`Gate::before` ルールは、 `false`ではなく `null` を返す必要があります。そうしないと、通常のポリシー操作に干渉します。[続きを見る](https://laracasts.com/discuss/channels/laravel/policy-gets-never-called#reply=492526)

Jeffrey Way は、 [Laravel 6 Authorization Filters](https://laracasts.com/series/laravel-6-from-scratch/episodes/51) ビデオとその章のいくつかの関連レッスンで、スーパー管理者（およびモデル所有者とモデルポリシー）の概念について説明しています。

## `Gate::after`

<!-- Alternatively you might want to move the Super Admin check to the `Gate::after` phase instead, particularly if your Super Admin shouldn't be allowed to do things your app doesn't want "anyone" to do, such as writing more than 1 review, or bypassing unsubscribe rules, etc. -->

<!-- The following code snippet is inspired from [Freek's blog article](https://murze.be/when-to-use-gateafter-in-laravel) where this topic is discussed further. -->

または、スーパー管理者チェックを `Gate::after` として代替することもできます。特に、複数のレビューを書き込んだり、バイパスしたりするなど、ユーザーに対して実行させたくないことを、スーパー管理者が許可させない、という場合です。

次のコードスニペットは、このトピックがさらに説明されている [Freek](https://murze.be/when-to-use-gateafter-in-laravel) のブログ記事から着想を得ています。

```php
// somewhere in a service provider

Gate::after(function ($user, $ability) {
   return $user->hasRole('Super Admin'); // note this returns boolean
});
```
