---
extends: _layouts.blog
section: body
title: 基本的な使用法
tags: 初学者向け
author: https://spatie.be/
slide: false
weight: 1
---

<!-- First, add the `Spatie\Permission\Traits\HasRoles` trait to your `User` model(s): -->

まず、User モデルに `Spatie\Permission\Traits\HasRoles` 特性を追加します。

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // ...
}
```

<!-- This package allows for users to be associated with permissions and roles. Every role is associated with multiple permissions.
A `Role` and a `Permission` are regular Eloquent models. They require a `name` and can be created like this: -->

このパッケージを使用すると、ユーザーを権限(Permissions)と役割(Roles)に関連付けることができます。すべての役割(Role)は複数の権限(Permissions)に関連付けられています。`Role`と `Permission` は通常の Eloquent モデルです。それらは `name` を必要とし、以下のように 役割、もしくは権限 を作成することができます。

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

$role = Role::create(['name' => 'writer']);
$permission = Permission::create(['name' => 'edit articles']);
```

<!-- A permission can be assigned to a role using 1 of these methods: -->

次のいずれかの方法を使用して、権限 (Permission) を 役割 (Role) に割り当てることができます。

```php
$role->givePermissionTo($permission);
$permission->assignRole($role);
```

<!-- Multiple permissions can be synced to a role using 1 of these methods: -->

次のいずれかの方法を使用して、複数の権限 (Permission) を役割 (Role) に同期できます。

```php
$role->syncPermissions($permissions);
$permission->syncRoles($roles);
```

<!-- A permission can be removed from a role using 1 of these methods: -->

次のいずれかの方法を使用して、権限 (Permission) を役割 (Role)から削除できます。

```php
$role->revokePermissionTo($permission);
$permission->removeRole($role);
```

<!-- If you're using multiple guards the `guard_name` attribute needs to be set as well. Read about it in the [using multiple guards](./multiple-guards) section of the readme.

The `HasRoles` trait adds Eloquent relationships to your models, which can be accessed directly or used as a base query: -->

複数のガードを使用している場合は、`guard_name` 属性も設定する必要があります。`readme` の[「複数のガードの使用」](./multiple-guards) セクションでそれについて読んでください。

`HasRoles トレイト` は、モデルに Eloquent のリレーションを追加します。このトレイトにより、リレーション先に直接アクセスすることも、基本クエリとして使用することもできます。

```php
// get a list of all permissions directly assigned to the user
$permissionNames = $user->getPermissionNames(); // collection of name strings
$permissions = $user->permissions; // collection of permission objects

// get all permissions for the user, either directly, or from roles, or from both
$permissions = $user->getDirectPermissions();
$permissions = $user->getPermissionsViaRoles();
$permissions = $user->getAllPermissions();

// get the names of the user's roles
$roles = $user->getRoleNames(); // Returns a collection
```

<!-- The `HasRoles` trait also adds a `role` scope to your models to scope the query to certain roles or permissions: -->

この `HasRolesトレイト`は `role` スコープをモデルに追加することで、特定の役割または権限に絞ったクエリを発行できます。

```php
$users = User::role('writer')->get(); // Returns only users with the role 'writer'
```

<!-- The `role` scope can accept a string, a `\Spatie\Permission\Models\Role` object or an `\Illuminate\Support\Collection` object.

The same trait also adds a scope to only get users that have a certain permission. -->

スコープは、文字列、オブジェクト、またはオブジェクトroleを受け入れることができます。\Spatie\Permission\Models\Role\Illuminate\Support\Collection

同じ特性により、特定の権限を持つユーザーのみを取得するスコープも追加されます。

```php
$users = User::permission('edit articles')->get(); // Returns only users with the permission 'edit articles' (inherited or directly)
```

<!-- The scope can accept a string, a `\Spatie\Permission\Models\Permission` object or an `\Illuminate\Support\Collection` object. -->

\Spatie\Permission\Models\Permissionスコープは、文字列、オブジェクト、またはオブジェクトを受け入れることができ\Illuminate\Support\Collectionます。

### Eloquent

<!-- Since Role and Permission models are extended from Eloquent models, basic Eloquent calls can be used as well: -->

ロールモデルとパーミッションモデルはEloquentモデルから拡張されているため、基本的な Eloquent 呼び出しもできます。

```php
$all_users_with_all_their_roles = User::with('roles')->get();
$all_users_with_all_direct_permissions = User::with('permissions')->get();
$all_roles_in_database = Role::all()->pluck('name');
$users_without_any_roles = User::doesntHave('roles')->get();
$all_roles_except_a_and_b = Role::whereNotIn('name', ['role A', 'role B'])->get();
```
