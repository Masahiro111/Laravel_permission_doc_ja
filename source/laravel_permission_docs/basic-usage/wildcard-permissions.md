---
title: ワイルドカードの権限
weight: 3
---

Wildcard permissions can be enabled in the permission config file:

ワイルドカードのアクセス許可は、アクセス許可の構成ファイルで有効にできます。

```php
// config/permission.php
'enable_wildcard_permission' => true,
```

When enabled, wildcard permissions offers you a flexible representation for a variety of permission schemes. The idea
 behind wildcard permissions is inspired by the default permission implementation of
 [Apache Shiro](https://shiro.apache.org/permissions.html).

A wildcard permission string is made of one or more parts separated by dots (.).

有効にすると、ワイルドカード権限により、さまざまな権限スキームを柔軟に表現できます。ワイルドカード権限の背後にある考え方は、 ApacheShiroのデフォルトの権限実装に触発されています 。

ワイルドカード許可文字列は、ドット（。）で区切られた1つ以上の部分で構成されます。

```php
$permission = 'posts.create.1';
```

The meaning of each part of the string depends on the application layer.

> You can use as many parts as you like. So you are not limited to the three-tiered structure, even though
this is the common use-case, representing {resource}.{action}.{target}.

> NOTE: You must actually create the permissions (eg: `posts.create.1`) before you can assign them or check for them.

> NOTE: You must create any wildcard permission patterns (eg: `posts.create.*`) before you can assign them or check for them.

文字列の各部分の意味は、アプリケーション層によって異なります。

パーツはいくつでも使用できます。したがって、これは{resource}。{action}。{target}を表す一般的なユースケースですが、3層構造に限定されません。

注：権限posts.create.1を割り当てたり確認したりする前に、実際に権限（例：）を作成する必要があります。

posts.create.*注：ワイルドカードを割り当てたり確認したりする前に、ワイルドカードのアクセス許可パターン（例:)を作成する必要があります。

### ワイルドカードの使用

> ALERT: The `*` means "ALL". It does **not** mean "ANY".

Each part can also contain wildcards (`*`). So let's say we assign the following permission to a user:

アラート：*「すべて」を意味します。「ANY」という意味ではありません。

各部分にはワイルドカード（*）を含めることもできます。したがって、次の権限をユーザーに割り当てたとします。

```php
Permission::create(['name'=>'posts.*']);
$user->givePermissionTo('posts.*');
// is the same as
Permission::create(['name'=>'posts']);
$user->givePermissionTo('posts');
```

Everyone who is assigned to this permission will be allowed every action on posts. It is not necessary to use a
wildcard on the last part of the string. This is automatically assumed.

この権限に割り当てられているすべての人は、投稿に対するすべてのアクションを許可されます。文字列の最後の部分にワイルドカードを使用する必要はありません。これは自動的に想定されます。

```php
// will be true
$user->can('posts.create');
$user->can('posts.edit');
$user->can('posts.delete');
```

### Meaning of the `*` Asterisk

*アスタリスクの意味

The `*` means "ALL". It does **not** mean "ANY".

Thus `can('post.*')` will only pass if the user has been assigned `post.*` explicitly.

「*すべて」を意味します。「ANY」という意味ではありません。

したがって、ユーザーが明示的can('post.*')に割り当てられている場合にのみ合格します。post.*

### Subparts

サブパーツ

Besides the use of parts and wildcards, subparts can also be used. Subparts are divided with commas (,). This is a
powerful feature that lets you create complex permission schemes.

パーツとワイルドカードの使用に加えて、サブパーツも使用できます。サブパートはコンマ（、）で区切られます。これは、複雑な権限スキームを作成できる強力な機能です。

```php
// user can only do the actions create, update and view on both resources posts and users
$user->givePermissionTo('posts,users.create,update,view');

// user can do the actions create, update, view on any available resource
$user->givePermissionTo('*.create,update,view');

// user can do any action on posts with ids 1, 4 and 6 
$user->givePermissionTo('posts.*.1,4,6');
```

> As said before, the meaning of each part is determined by the application layer! So, you are free to use each part as you like. And you can use as many parts and subparts as you want.

前に述べたように、各部分の意味はアプリケーション層によって決定されます！だから、あなたは好きなように各部分を自由に使うことができます。また、必要な数のパーツとサブパーツを使用できます。
