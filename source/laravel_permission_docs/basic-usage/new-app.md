---
title: サンプルアプリ
weight: 90
---

## デモアプリの作成

<!-- If you want to just try out the features of this package you can get started with the following. -->

<!-- The examples on this page are primarily added for assistance in creating a quick demo app for troubleshooting purposes, to post the repo on github for convenient sharing to collaborate or get support. -->

<!-- If you're new to Laravel or to any of the concepts mentioned here, you can learn more in the [Laravel documentation](https://laravel.com/docs/) and in the free videos at Laracasts such as with the [Laravel From Scratch series](https://laracasts.com/series/laravel-6-from-scratch/). -->

このパッケージの機能を試してみたい場合は、以下から始めることができます。

このページの例は主に、トラブルシューティングの目的でクイックデモアプリを作成し、共同作業やサポートを受けるために便利な共有のためにリポジトリを github に投稿するために追加されています。

Laravel やここで説明した概念のいずれかに慣れていない場合は、[Laravel](https://laravel.com/docs/) のドキュメントや、[LaravelFromScratch](https://laracasts.com/series/laravel-6-from-scratch/) シリーズなどのLaracastの無料ビデオで詳細を学ぶことができます。

### 初期設定

```sh
cd ~/Sites
laravel new mypermissionsdemo
cd mypermissionsdemo
git init
git add .
git commit -m "Fresh Laravel Install"

# Environment
cp -n .env.example .env
sed -i '' 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
sed -i '' 's/DB_DATABASE=/#DB_DATABASE=/' .env
touch database/database.sqlite

# Package
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
git add .
git commit -m "Add Spatie Laravel Permissions package"
php artisan migrate:fresh

# Add `HasRoles` trait to User model
sed -i '' $'s/use HasFactory, Notifiable;/use HasFactory, Notifiable;\\\n    use \\\\Spatie\\\\Permission\\\\Traits\\\\HasRoles;/' app/Models/User.php
sed -i '' $'s/use HasApiTokens, HasFactory, Notifiable;/use HasApiTokens, HasFactory, Notifiable;\\\n    use \\\\Spatie\\\\Permission\\\\Traits\\\\HasRoles;/' app/Models/User.php
git add . && git commit -m "Add HasRoles trait"

# Add Laravel's basic auth scaffolding
composer require laravel/ui --dev
php artisan ui bootstrap --auth
# npm install && npm run prod
git add . && git commit -m "Setup auth scaffold"
```

### いくつかの基本的な権限を追加

<!-- - Add a new file, `/database/seeders/PermissionsDemoSeeder.php` such as the following (You could create it with `php artisan make:seed` and then edit the file accordingly): -->

- `php artisan make:seed PermissionsDemoSeeder` コマンドで、新しいシーダーファイルを追加し、以下のように `/database/seeders/PermissionsDemoSeeder.php` を編集してください。

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role3);
    }
}

```

- データベースを再度マイグレーションします。

```sh
php artisan migrate:fresh --seed --seeder=PermissionsDemoSeeder
```

### スーパー管理者アクセスの許可

<!-- Super-Admins are a common feature. The following approach allows that when your Super-Admin user is logged in, all permission-checks in your app which call `can()` or `@can()` will return true. -->

<!-- - Create a role named `Super-Admin`. (Or whatever name you wish; but use it consistently just like you must with any role name.) -->
<!-- - Add a Gate::before check in your `AuthServiceProvider`: -->

スーパー管理者は一般的な機能です。次のアプローチでは、スーパー管理者がログインしているときに、`can()`、または `@can()` は、すべての権限チェックに `true` を返します。

- `Super-Admin` という名前の役割 (Role) を作成します。（または任意の名前でもOK。ただし、他のロール名と同じように一貫して使用してください。）
- `AuthServiceProvider` に`Gate::before` を追加してください

```diff
    public function boot()
    {
        $this->registerPolicies();
        
        //

+        // Implicitly grant "Super-Admin" role all permission checks using can()
+        Gate::before(function ($user, $ability) {
+            if ($user->hasRole('Super-Admin')) {
+                return true;
+            }
+        });
    }
```

### アプリケーションコード

<!-- The permissions created in the seeder above imply that there will be some sort of Posts or Article features, and that various users will have various access control levels to manage/view those objects. -->

<!-- Your app will have Models, Controllers, routes, Views, Factories, Policies, Tests, middleware, and maybe additional Seeders. -->

<!-- You can see examples of these in the demo app at <https://github.com/drbyte/spatie-permissions-demo/> -->

上記のシーダーで作成された権限は、ある種の投稿または記事の機能があり、さまざまなユーザーがそれらのオブジェクトを管理/表示するためのさまざまなアクセス制御レベルを持っていることを意味します。

アプリには、モデル、コントローラー、ルート、ビュー、ファクトリー、ポリシー、テスト、ミドルウェア、および場合によっては追加のシーダーが含まれます。

これらの例は、<https://github.com/drbyte/spatie-permissions-demo/> のデモアプリで確認できます。

## 共有

<!-- To share your app on Github for easy collaboration: -->

<!-- - create a new public repository on Github, without any extras like readme/etc. -->
<!-- - follow github's sample code for linking your local repo and uploading the code. It will look like this: -->

簡単なコラボレーションのためにGithubでアプリを共有するには：

- `readme / etc`のような追加機能なしで、Github に新しいパブリックリポジトリを作成します。
- ローカルリポジトリをリンクしてコードをアップロードするには、github のサンプルコードに従ってください。次のようになります。

```sh
git remote add origin git@github.com:YOURUSERNAME/REPONAME.git
git push -u origin main
```

<!-- The above only needs to be done once. -->

上記は一度だけ行う必要があります。

<!-- - then add the rest of your code by making new commits: -->

次に、新しいコミットを作成して、残りのコードを追加します。

```sh
git add .
git commit -m "Explain what your commit is about here"
git push origin main
```

<!-- Repeat the above process whenever you change code that you want to share. -->

<!-- Those are the basics! -->

共有するコードを変更するたびに、上記のプロセスを繰り返します。

以上が基本です！
