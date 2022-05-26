---
title: ロールを介した権限の使用
weight: 3
---

## 役割の割り当て

<!-- A role can be assigned to any user: -->

役割(Role) は任意のユーザーに割り当てることができます。

```php
$user->assignRole('writer');

// You can also assign multiple roles at once
$user->assignRole('writer', 'admin');
// or as an array
$user->assignRole(['writer', 'admin']);
```

A role can be removed from a user:

役割(Role) はユーザーから削除できます。

```php
$user->removeRole('writer');
```

<!-- Roles can also be synced: -->

役割を同期することもできます。

```php
// All current roles will be removed from the user and replaced by the array given
$user->syncRoles(['writer', 'admin']);
```

## 役割の確認

<!-- You can determine if a user has a certain role: -->

ユーザーが特定の役割を持っているかどうかを判断できます。

```php
$user->hasRole('writer');

// or at least one role from an array of roles:
$user->hasRole(['editor', 'moderator']);
```

<!-- You can also determine if a user has any of a given list of roles: -->

また、ユーザーが特定の役割(Role) のリストのいずれかを持っているかどうかを判断することもできます。

```php
$user->hasAnyRole(['writer', 'reader']);
// or
$user->hasAnyRole('writer', 'reader');
```

<!-- You can also determine if a user has all of a given list of roles: -->

また、ユーザーが特定の役割のリストをすべて持っているかどうかを判断することもできます。

```php
$user->hasAllRoles(Role::all());
```

<!-- You can also determine if a user has exactly all of a given list of roles: -->

また、ユーザーが特定の役割のリストをすべて正確に持っているかどうかを判断することもできます。

```php
$user->hasExactRoles(Role::all());
```

The `assignRole`, `hasRole`, `hasAnyRole`, `hasAllRoles`, `hasExactRoles`  and `removeRole` functions can accept a
 string, a `\Spatie\Permission\Models\Role` object or an `\Illuminate\Support\Collection` object.

`assignRole`, `hasRole`, `hasAnyRole`, `hasAllRoles`, `hasExactRoles`  及び `removeRole` メソッド関数は、文字列、`\Spatie\Permission\Models\Role`  `\Illuminate\Support\Collection` を受け入れることができます。

## ロールへの権限の割り当て

<!-- A permission can be given to a role: -->

役割に許可を与えることができます。

```php
$role->givePermissionTo('edit articles');
```

<!-- You can determine if a role has a certain permission: -->

ロールに特定の権限があるかどうかを判断できます。

```php
$role->hasPermissionTo('edit articles');
```

<!-- A permission can be revoked from a role: -->

権限はロールから取り消すことができます。

```php
$role->revokePermissionTo('edit articles');
```

<!-- The `givePermissionTo` and `revokePermissionTo` functions can accept a
string or a `Spatie\Permission\Models\Permission` object. -->

<!-- **NOTE: Permissions are inherited from roles automatically.** -->

`givePermissionTo` と `revokePermissionTo` 関数は、文字列または `Spatie\Permission\Models\Permission` オブジェクトを受け入れることができます。

注：権限はロールから自動的に継承されます。

### Role にはどのような権限がありますか？

<!-- The `permissions` property on any given role returns a collection with all the related permission objects. This collection can respond to usual Eloquent Collection operations, such as count, sort, etc. -->

複数の役割(Role)が与えられている `permissions` プロパティは、関連するすべての Permission オブジェクトを含むコレクションを返します。このコレクションは、カウント、ソートなどの通常の `Eloquent Collection` 操作に応答できます。

```php
// get collection
$role->permissions;

// return only the permission names:
$role->permissions->pluck('name');

// count the number of permissions assigned to a role
count($role->permissions);
// or
$role->permissions->count();
```

## ユーザーへの直接アクセス許可の割り当て

Additionally, individual permissions can be assigned to the user too.
<!-- For instance: -->

さらに、個々の権限をユーザーに割り当てることもできます。例えば：

```php
$role = Role::findByName('writer');
$role->givePermissionTo('edit articles');

$user->assignRole('writer');

$user->givePermissionTo('delete articles');
```

In the above example, a role is given permission to edit articles and this role is assigned to a user.
Now the user can edit articles and additionally delete articles. The permission of 'delete articles' is the user's direct permission because it is assigned directly to them.
When we call `$user->hasDirectPermission('delete articles')` it returns `true`,
but `false` for `$user->hasDirectPermission('edit articles')`.

This method is useful if one builds a form for setting permissions for roles and users in an application and wants to restrict or change inherited permissions of roles of the user, i.e. allowing to change only direct permissions of the user.

You can check if the user has a Specific or All or Any of a set of permissions directly assigned:

上記の例では、ロールに記事を編集する権限が与えられ、このロールがユーザーに割り当てられています。これで、ユーザーは記事を編集し、さらに記事を削除できます。「記事の削除」の権限は、ユーザーに直接割り当てられているため、ユーザーの直接の権限です。呼び出す$user->hasDirectPermission('delete articles')と、が返されますtrueがfalse、$user->hasDirectPermission('edit articles')。

この方法は、アプリケーションで役割とユーザーのアクセス許可を設定するためのフォームを作成し、ユーザーの役割の継承されたアクセス許可を制限または変更する場合、つまりユーザーの直接のアクセス許可のみを変更できるようにする場合に役立ちます。

ユーザーが直接割り当てられた一連の権限の特定またはすべてまたはいずれかを持っているかどうかを確認できます。

```php
// Check if the user has Direct permission
$user->hasDirectPermission('edit articles')

// Check if the user has All direct permissions
$user->hasAllDirectPermissions(['edit articles', 'delete articles']);

// Check if the user has Any permission directly
$user->hasAnyDirectPermission(['create articles', 'delete articles']);
```

By following the previous example, when we call `$user->hasAllDirectPermissions(['edit articles', 'delete articles'])`
it returns `true`, because the user has all these direct permissions.
When we call
`$user->hasAnyDirectPermission('edit articles')`, it returns `true` because the user has one of the provided permissions.

You can examine all of these permissions:

前の例に従うと、ユーザーがこれらすべての直接アクセス許可を持っているため、呼び出す$user->hasAllDirectPermissions(['edit articles', 'delete articles']) とが返されます。trueを呼び出すと 、ユーザーが提供された権限の1つを持っているため、$user->hasAnyDirectPermission('edit articles')戻ります。true

これらの権限をすべて調べることができます。

```php
// Direct permissions
$user->getDirectPermissions() // Or $user->permissions;

// Permissions inherited from the user's roles
$user->getPermissionsViaRoles();

// All permissions which apply on the user (inherited and direct)
$user->getAllPermissions();
```

All these responses are collections of `Spatie\Permission\Models\Permission` objects.

If we follow the previous example, the first response will be a collection with the `delete article` permission and
the second will be a collection with the `edit article` permission and the third will contain both.

これらの応答はすべて、Spatie\Permission\Models\Permissionオブジェクトのコレクションです。

前の例に従うと、最初の応答はdelete article許可のあるコレクションになり、2番目の応答は許可のあるコレクションにedit articleなり、3番目の応答には両方が含まれます。

### ポリシーでの権限名の使用に関する注意

When calling `authorize()` for a policy method, if you have a permission named the same as one of those policy methods, your permission "name" will take precedence and not fire the policy. For this reason it may be wise to avoid naming your permissions the same as the methods in your policy. While you can define your own method names, you can read more about the defaults Laravel offers in Laravel's documentation at <https://laravel.com/docs/authorization#writing-policies>

ポリシーメソッドを呼び出すときauthorize()に、それらのポリシーメソッドの1つと同じ名前のアクセス許可がある場合、アクセス許可の「名前」が優先され、ポリシーは実行されません。このため、ポリシーのメソッドと同じように権限に名前を付けることは避けるのが賢明かもしれません。独自のメソッド名を定義することもできますが、Laravelが提供するデフォルトの詳細については、Laravelのドキュメント（<https://laravel.com/docs/authorization#writing-policies>）を参照してください。
