---
title: ブレードディレクティブ
weight: 4
---

## 権限 (Permissions)

<!-- This package doesn't add any **permission**-specific Blade directives. -->
<!-- Instead, use Laravel's native `@can` directive to check if a user has a certain permission. -->

このパッケージは、パーミッション固有の Blade ディレクティブを追加しません。代わりに、Laravelのネイティブ `@can` ディレクティブを使用して、ユーザーが特定の権限 (Permission) を持っているかどうかを確認してください。

```php
@can('edit articles')
  //
@endcan
```

または

```php
@if(auth()->user()->can('edit articles') && $some_other_condition)
  //
@endif
```

<!-- You can use `@can`, `@cannot`, `@canany`, and `@guest` to test for permission-related access. -->

`@can`, `@cannot`, `@canany` 及び `@guest` ディレクティブを使用して、権限 (Permission) 関連のアクセスをテストできます。

## 役割 (Roles)

<!-- As discussed in the Best Practices section of the docs, **it is strongly recommended to always use permission directives**, instead of role directives. -->

<!-- Additionally, if your reason for testing against Roles is for a Super-Admin, see the *Defining A Super-Admin* section of the docs. -->

<!-- If you actually need to test for Roles, this package offers some Blade directives to verify whether the currently logged in user has all or any of a given list of roles. -->

<!-- Optionally you can pass in the `guard` that the check will be performed on as a second argument. -->

ドキュメントのベストプラクティスのセクションで説明されているように、**ロールディレクティブではなく、常にパーミッションディレクティブ用すること** を強くお勧めします。

さらに、役割 (Role) に対してテストする理由がスーパー管理者向けである場合は、ドキュメントの 「スーパー管理者の定義 」 セクションを参照してください。

実際に役割 (Role) をテストする必要がある場合、このパッケージは、現在ログインしているユーザーが特定の役割 (Role) のリストのすべてまたはいずれかを持っているかどうかを確認するためのいくつかの Blade ディレクティブを用意しています。

オプションとして、 guard でチェックが実行されることを2番目の引数として渡すことができます。

#### ブレードと役割 (Roles)

<!-- Check for a specific role: -->

特定の役割 (Role) を確認します。

```php
@role('writer')
    I am a writer!
@else
    I am not a writer...
@endrole
```

<!-- is the same as -->

と同じです

```php
@hasrole('writer')
    I am a writer!
@else
    I am not a writer...
@endhasrole
```

<!-- Check for any role in a list: -->

リスト内の役割 (Role) を確認します。

```php
@hasanyrole($collectionOfRoles)
    I have one or more of these roles!
@else
    I have none of these roles...
@endhasanyrole
// or
@hasanyrole('writer|admin')
    I am either a writer or an admin or both!
@else
    I have none of these roles...
@endhasanyrole
```

<!-- Check for all roles: -->

すべての役割を確認します。

```php
@hasallroles($collectionOfRoles)
    I have all of these roles!
@else
    I do not have all of these roles...
@endhasallroles
// or
@hasallroles('writer|admin')
    I am both a writer and an admin!
@else
    I do not have all of these roles...
@endhasallroles
```

<!-- Alternatively, `@unlessrole` gives the reverse for checking a singular role, like this: -->

`@unlessrole` は単一の役割 (Role) が「偽」になるかをチェックします。

```php
@unlessrole('does not have this role')
    I do not have the role
@else
    I do have the role
@endunlessrole
```

<!-- You can also determine if a user has exactly all of a given list of roles: -->

また、ユーザーが特定の役割 (Role) のリストをすべて正確に持っているかどうかを判断することもできます。

```php
@hasexactroles('writer|admin')
    I am both a writer and an admin and nothing else!
@else
    I do not have all of these roles or have more other roles...
@endhasexactroles
```
