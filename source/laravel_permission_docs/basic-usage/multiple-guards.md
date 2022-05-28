---
title: 複数のガードを使用する
weight: 6
---

<!-- When using the default Laravel auth configuration all of the core methods of this package will work out of the box, no extra configuration required. -->

<!-- However, when using multiple guards they will act like namespaces for your permissions and roles. Meaning every guard has its own set of permissions and roles that can be assigned to their user model. -->

デフォルトの Laravel 認証構成を使用する場合、このパッケージのすべてのコアメソッドはそのままで機能します。追加の構成は必要ありません。

ただし、複数のガードを使用する場合、それらは権限 (Permission) と役割 (Role) の名前付けのように機能します。つまり、すべてのガードには、ユーザーモデルに割り当てることができる独自の権限 (Permission) と役割 (Role) のセットがあります。

### 複数ガードの欠点

<!-- Note that this package requires you to register a permission name for each guard you want to authenticate with. So, "edit-article" would have to be created multiple times for each guard your app uses. An exception will be thrown if you try to authenticate against a non-existing permission+guard combination. Same for roles. -->

<!-- > **Tip**: If your app uses only a single guard, but is not `web` (Laravel's default, which shows "first" in the auth config file) then change the order of your listed guards in your `config/auth.php` to list your primary guard as the default and as the first in the list of defined guards. -->
<!-- While you're editing that file, best to remove any guards you don't use, too. -->

このパッケージでは、認証するガードごとに権限 (Permission) 名を登録する必要があることに注意してください。したがって、「edit-article (記事の編集) 」は、アプリが使用するガードごとに複数回作成する必要があります。存在しないパーミッションとガードの組み合わせに対して認証しようとすると、例外がスローされます。役割 (Role) についても同じです。

> ヒント：プロダクトが単一のガードのみを使用していて、かつ、web（Laravelのデフォルトの認証構成ファイルに最初に入力されているガード名です。）ガードを使用していない場合 、`config/auth.php` 内にリストされているガードの順序を変更して、プライマリガードをデフォルトとしてリストし、定義されたガードのリストの始めとします。そのファイルを編集している間は、使用していないガードも削除することをお勧めします。

### 複数のガードによる権限 (Permission) と役割 (Role) の使用

<!-- When creating new permissions and roles, if no guard is specified, then the **first** defined guard in `auth.guards` config array will be used. -->

新しい権限 (Permission) と役割 (Role) を作成するときに、ガードが指定されていない場合、`auth.guards` 構成配列で最初に定義されたガードが使用されます。

```php
// Create a manager role for users authenticating with the admin guard:
$role = Role::create(['guard_name' => 'admin', 'name' => 'manager']);

// Define a `publish articles` permission for the admin users belonging to the admin guard
$permission = Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);

// Define a *different* `publish articles` permission for the regular users belonging to the web guard
$permission = Permission::create(['guard_name' => 'web', 'name' => 'publish articles']);
```

<!-- To check if a user has permission for a specific guard: -->

ユーザーが特定のガードの権限 (Permission) を持っているかどうかを確認するには：

```php
$user->hasPermissionTo('publish articles', 'admin');
```

<!-- > **Note**: When determining whether a role/permission is valid on a given model, it checks against the first matching guard in this order (it does NOT check role/permission for EACH possibility, just the first match): -->

<!-- - first the guardName() method if it exists on the model;
- then the `$guard_name` property if it exists on the model;
- then the first-defined guard/provider combination in the `auth.guards` config array that matches the logged-in user's guard;
- then the `auth.defaults.guard` config (which is the user's guard if they are logged in, else the default in the file). -->

> 注：特定のモデルで役割/許可が有効かどうかを判断する場合、最初に一致するガードをこの順序でチェックします（各可能性について役割/許可をチェックせず、最初の一致のみをチェックします）。

- はじめに、`guardName()` メソッドがモデルに存在すること。
- 次に、`$guard_name` プロパティがモデルに存在すること。
- 次に、`auth.guards` コンフィグの配列がログインしたユーザーのガードと一致すること。その一致したコンフィグファイルは、最初に定義されたガード/プロバイダーの組み合わせ。
- 次に、`auth.defaults.guard` 構成（ログインしている場合はユーザーのガード、それ以外の場合はファイルのデフォルト）。

### ユーザーを保護するための権限 (Permission) と役割 (Role) の割り当て

<!-- You can use the same core methods to assign permissions and roles to users; just make sure the `guard_name` on the permission or role matches the guard of the user, otherwise a `GuardDoesNotMatch` or `Role/PermissionDoesNotExist` exception will be thrown. -->

同じコアメソッドを使用して、ユーザーに権限 (Permission) と役割 (Role) を割り当てることができます。`guard_name` パーミッションまたはロールがユーザーのガードと一致することを確認してください。一致しない場合、`GuardDoesNotMatch` または `Role/PermissionDoesNotExist` 例外がスローされます。

### 複数のガードでブレードディレクティブを使用する

<!-- You can use all of the blade directives offered by this package by passing in the guard you wish to use as the second argument to the directive: -->

このパッケージで提供されるすべてのブレードディレクティブは、2番目の引数に使用するガードの名前を渡すことができます。

```php
@role('super-admin', 'admin')
    I am a super-admin!
@else
    I am not a super-admin...
@endrole
```
