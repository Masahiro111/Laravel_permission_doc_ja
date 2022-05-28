---
title: Artisan コマンドを使用する
weight: 7
---

## Artisanコマンドを使用した役割 (Role) と権限 (Permission) の作成

<!-- You can create a role or permission from the console with artisan commands. -->

Artisan コマンドを使用して、コンソールから役割 (Role) または権限 (Permission) を作成できます。

```bash
php artisan permission:create-role writer
```

```bash
php artisan permission:create-permission "edit articles"
```

<!-- When creating permissions/roles for specific guards you can specify the guard names as a second argument: -->

特定のガードの権限 (Permission) /役割 (Role) を作成する場合、2番目の引数としてガード名を指定できます。

```bash
php artisan permission:create-role writer web
```

```bash
php artisan permission:create-permission "edit articles" web
```

<!-- When creating roles you can also create and link permissions at the same time: -->

役割 (Role) を作成するときに、権限 (Permission) の作成とリンクを同時に行うこともできます。

```bash
php artisan permission:create-role writer web "create articles|edit articles"
```

When creating roles with teams enabled you can set the team id by adding the `--team-id` parameter:

チームを有効にして役割 (Role) を作成する場合、`--team-id` パラメーターを追加してチームIDを設定できます。

```bash
php artisan permission:create-role --team-id=1 writer
php artisan permission:create-role writer api --team-id=1
```

## コンソールでの役割 (Role) と権限 (Permission) の表示

<!-- There is also a `show` command to show a table of roles and permissions per guard: -->

ガードごとの役割 (Role) と権限 (Permission) のテーブルを表示する `show` コマンドもあります。

```bash
php artisan permission:show
```

## キャッシュのリセット

<!-- When you use the built-in functions for manipulating roles and permissions, the cache is automatically reset for you, and relations are automatically reloaded for the current model record. -->

<!-- See the Advanced-Usage/Cache section of these docs for detailed specifics. -->

<!-- If you need to manually reset the cache for this package, you may use the following artisan command: -->

組み込み関数を使用して役割 (Role) と権限 (Permission) を操作すると、キャッシュが自動的にリセットされ、現在のモデルレコードのリレーションが自動的に再ロードされます。

詳細については、これらのドキュメントの「Advanced-Usage/Cache」セクションを参照してください。

このパッケージのキャッシュを手動でリセットする必要がある場合は、次の Artisan コマンドを使用できます。

```bash
php artisan permission:cache-reset
```

<!-- Again, it is more efficient to use the API provided by this package, instead of manually clearing the cache. -->

繰り返しになりますが、キャッシュを手動でクリアするよりも、このパッケージによって提供されるAPIを使用する方が効率的です。
