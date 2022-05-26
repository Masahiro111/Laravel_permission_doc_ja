---
title: スーパー管理者の定義
weight: 5
---

We strongly recommend that a Super-Admin be handled by setting a global `Gate::before` or `Gate::after` rule which checks for the desired role.

Then you can implement the best-practice of primarily using permission-based controls (@can and $user->can, etc) throughout your app, without always having to check for "is this a super-admin" everywhere. Best not to use role-checking (ie: `hasRole`) when you have Super Admin features like this.

スーパー管理者は、目的の役割をチェックするグローバルルールGate::beforeまたはルールを設定して処理することを強くお勧めします。Gate::after

次に、アプリ全体で主に権限ベースのコントロール（@canおよび$ user-> canなど）を使用するベストプラクティスを実装できます。常に「これはスーパー管理者ですか」をどこでもチェックする必要はありません。hasRoleこのようなスーパー管理機能がある場合は、ロールチェック（例:)を使用しないことをお勧めします。

## `Gate::before`

If you want a "Super Admin" role to respond `true` to all permissions, without needing to assign all those permissions to a role, you can use Laravel's `Gate::before()` method. For example:

「スーパー管理者」の役割がすべての権限に応答するようにしたい場合は、trueそれらのすべての権限を役割に割り当てる必要はなく、LaravelのGate::before()方法を使用できます。例えば：

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

NOTE: `Gate::before` rules need to return `null` rather than `false`, else it will interfere with normal policy operation. [See more.](https://laracasts.com/discuss/channels/laravel/policy-gets-never-called#reply=492526)

Jeffrey Way explains the concept of a super-admin (and a model owner, and model policies) in the [Laravel 6 Authorization Filters](https://laracasts.com/series/laravel-6-from-scratch/episodes/51) video and some related lessons in that chapter.

注：Gate::beforeルールは、nullではなく返す必要がありfalseます。そうしないと、通常のポリシー操作に干渉します。続きを見る。

Jeffrey Wayは、 Laravel 6 Authorization Filtersビデオとその章のいくつかの関連レッスンで、スーパー管理者（およびモデル所有者とモデルポリシー）の概念について説明しています。

## `Gate::after`

Alternatively you might want to move the Super Admin check to the `Gate::after` phase instead, particularly if your Super Admin shouldn't be allowed to do things your app doesn't want "anyone" to do, such as writing more than 1 review, or bypassing unsubscribe rules, etc.

The following code snippet is inspired from [Freek's blog article](https://murze.be/when-to-use-gateafter-in-laravel) where this topic is discussed further.

または、代わりにスーパー管理者チェックをGate::afterフェーズに移動することもできます。特に、複数のレビューを書き込んだり、バイパスしたりするなど、アプリが「誰でも」実行したくないことをスーパー管理者が許可してはならない場合はそうです。購読解除ルールなど。

次のコードスニペットは、このトピックがさらに説明されているFreekのブログ記事から着想を得ています。

```php
// somewhere in a service provider

Gate::after(function ($user, $ability) {
   return $user->hasRole('Super Admin'); // note this returns boolean
});
```
