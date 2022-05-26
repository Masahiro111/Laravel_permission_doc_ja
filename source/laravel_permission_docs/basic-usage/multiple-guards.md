---
title: 複数のガードを使用する
weight: 6
---

When using the default Laravel auth configuration all of the core methods of this package will work out of the box, no extra configuration required.

However, when using multiple guards they will act like namespaces for your permissions and roles. Meaning every guard has its own set of permissions and roles that can be assigned to their user model.

デフォルトのLaravel認証構成を使用する場合、このパッケージのすべてのコアメソッドはそのままで機能します。追加の構成は必要ありません。

ただし、複数のガードを使用する場合、それらは権限と役割の名前付けのように機能します。つまり、すべてのガードには、ユーザーモデルに割り当てることができる独自の権限と役割のセットがあります。

### The Downside To Multiple Guards

複数の警備員の欠点

Note that this package requires you to register a permission name for each guard you want to authenticate with. So, "edit-article" would have to be created multiple times for each guard your app uses. An exception will be thrown if you try to authenticate against a non-existing permission+guard combination. Same for roles.

> **Tip**: If your app uses only a single guard, but is not `web` (Laravel's default, which shows "first" in the auth config file) then change the order of your listed guards in your `config/auth.php` to list your primary guard as the default and as the first in the list of defined guards. While you're editing that file, best to remove any guards you don't use, too.

このパッケージでは、認証するガードごとに権限名を登録する必要があることに注意してください。したがって、「記事の編集」は、アプリが使用するガードごとに複数回作成する必要があります。存在しないパーミッションとガードの組み合わせに対して認証しようとすると、例外がスローされます。役割についても同じです。

ヒント：アプリが単一のガードのみを使用しているが使用していない場合web（Laravelのデフォルト。認証構成ファイルに「最初」と表示されます）、リストされているガードの順序を変更してconfig/auth.php、プライマリガードをデフォルトとしてリストします。定義されたガードのリストの最初。そのファイルを編集している間は、使用していないガードも削除することをお勧めします。

### Using permissions and roles with multiple guards

複数の警備員による権限と役割の使用

When creating new permissions and roles, if no guard is specified, then the **first** defined guard in `auth.guards` config array will be used.

新しい権限とロールを作成するときに、ガードが指定されていない場合、構成配列で最初に定義されたガードが使用されます。auth.guards

```php
// Create a manager role for users authenticating with the admin guard:
$role = Role::create(['guard_name' => 'admin', 'name' => 'manager']);

// Define a `publish articles` permission for the admin users belonging to the admin guard
$permission = Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);

// Define a *different* `publish articles` permission for the regular users belonging to the web guard
$permission = Permission::create(['guard_name' => 'web', 'name' => 'publish articles']);
```

To check if a user has permission for a specific guard:

ユーザーが特定のガードの権限を持っているかどうかを確認するには：

```php
$user->hasPermissionTo('publish articles', 'admin');
```

> **Note**: When determining whether a role/permission is valid on a given model, it checks against the first matching guard in this order (it does NOT check role/permission for EACH possibility, just the first match):

- first the guardName() method if it exists on the model;
- then the `$guard_name` property if it exists on the model;
- then the first-defined guard/provider combination in the `auth.guards` config array that matches the logged-in user's guard;
- then the `auth.defaults.guard` config (which is the user's guard if they are logged in, else the default in the file).

注：特定のモデルで役割/許可が有効かどうかを判断する場合、最初に一致するガードをこの順序でチェックします（各可能性について役割/許可をチェックせず、最初の一致のみをチェックします）。

モデルに存在する場合は、最初にguardName（）メソッド。
次に、$guard_nameモデルに存在する場合はプロパティ。
auth.guards次に、ログインしたユーザーのガードと一致するconfigアレイ内の最初に定義されたガード/プロバイダーの組み合わせ。
次に、auth.defaults.guard構成（ログインしている場合はユーザーのガード、それ以外の場合はファイルのデフォルト）。

### Assigning permissions and roles to guard users

ユーザーを保護するための権限と役割の割り当て

You can use the same core methods to assign permissions and roles to users; just make sure the `guard_name` on the permission or role matches the guard of the user, otherwise a `GuardDoesNotMatch` or `Role/PermissionDoesNotExist` exception will be thrown.

同じコアメソッドを使用して、ユーザーに権限と役割を割り当てることができます。guard_nameonパーミッションまたはロールがユーザーのガードと一致することを確認してください。一致しない場合、GuardDoesNotMatchまたはRole/PermissionDoesNotExist例外がスローされます。

### Using blade directives with multiple guards

複数のガードでブレードディレクティブを使用する

You can use all of the blade directives offered by this package by passing in the guard you wish to use as the second argument to the directive:

ディレクティブの2番目の引数として使用するガードを渡すことにより、このパッケージで提供されるすべてのブレードディレクティブを使用できます。

```php
@role('super-admin', 'admin')
    I am a super-admin!
@else
    I am not a super-admin...
@endrole
```
