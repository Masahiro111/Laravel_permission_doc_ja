---
extends: _layouts.blog
section: body
title: 直接アクセス許可
author: https://spatie.be/
slide: false
weight: 2
---

<!-- A permission can be given to any user: -->

すべてのユーザーに許可を与えることができます。

```php
$user->givePermissionTo('edit articles');

// You can also give multiple permission at once
$user->givePermissionTo('edit articles', 'delete articles');

// You may also pass an array
$user->givePermissionTo(['edit articles', 'delete articles']);
```

<!-- A permission can be revoked from a user: -->

ユーザーから権限を取り消すことができます。

```php
$user->revokePermissionTo('edit articles');
```

<!-- Or revoke & add new permissions in one go: -->

または、一度に取り消して、新しい権限を追加します。

```php
$user->syncPermissions(['edit articles', 'delete articles']);
```

<!-- You can check if a user has a permission: -->

ユーザーに権限があるかどうかを確認できます。

```php
$user->hasPermissionTo('edit articles');
```

<!-- Or you may pass an integer representing the permission id -->

または、パーミッションIDを表す整数を渡すこともできます

```php
$user->hasPermissionTo('1');
$user->hasPermissionTo(Permission::find(1)->id);
$user->hasPermissionTo($somePermission->id);
```

<!-- You can check if a user has Any of an array of permissions: -->

ユーザーが一連の権限のいずれかを持っているかどうかを確認できます。

```php
$user->hasAnyPermission(['edit articles', 'publish articles', 'unpublish articles']);
```

<!-- ...or if a user has All of an array of permissions: -->

...または、ユーザーがすべての権限を持っている場合：

```php
$user->hasAllPermissions(['edit articles', 'publish articles', 'unpublish articles']);
```

<!-- You may also pass integers to lookup by permission id -->

パーミッションIDでルックアップに整数を渡すこともできます

```php
$user->hasAnyPermission(['edit articles', 1, 5]);
```

<!-- Saved permissions will be registered with the `Illuminate\Auth\Access\Gate` class for the default guard. So you can
check if a user has a permission with Laravel's default `can` function: -->

保存された権限(Permission) は 、デフォルトのガードである `Illuminate\Auth\Access\Gate` クラスに登録されます。なので、ユーザーが権限(Permission) を持っているかどうかを Laravelのデフォルトの `can` 機能で確認することができます。

```php
$user->can('edit articles');
```
