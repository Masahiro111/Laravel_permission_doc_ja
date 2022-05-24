---
title: 序章
weight: 1
---

このパッケージを使用すると、データベース内のユーザー権限と役割を管理できます。

インストールすると、次のようなことができます。

```php
// Adding permissions to a user
$user->givePermissionTo('edit articles');

// Adding permissions via a role
$user->assignRole('writer');

$role->givePermissionTo('edit articles');
```

<!-- If you're using multiple guards we've got you covered as well. Every guard will have its own set of permissions and roles that can be assigned to the guard's users. Read about it in the [using multiple guards](./basic-usage/multiple-guards/) section.

Because all permissions will be registered on [Laravel's gate](https://laravel.com/docs/authorization), you can check if a user has a permission with Laravel's default `can` function: -->

複数のガードを使用している場合は、同様にカバーされます。すべてのガードには、ガードのユーザーに割り当てることができる独自の権限と役割のセットがあります。[複数のガード](./basic-usage/multiple-guards/) の使用のセクションでそれについて読んでください。

すべての権限は[Laravelのゲート](https://laravel.com/docs/authorization) に登録されるため、ユーザーがLaravelのデフォルト `can` 機能で権限を持っているかどうかを確認できます。

```php
$user->can('edit articles');
```

およびBladeディレクティブ：

```blade
@can('edit articles')
...
@endcan
```
