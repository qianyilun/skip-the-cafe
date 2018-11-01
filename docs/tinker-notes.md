# Tinker Notes
Create a new record:
```php
$post = App\Post::create(['title'=>'tinker post', 'content'=>'tinker content']);
```

Another way of create:
```php
$post = new App\Post;
$post->title = '123';
$post->save();
```

```php
$post = App\Post::find(2)
$post->save();
$post->delete();
```

Drop a table in the database:
```php
Schema::drop('users');
```

To insert directly in to a specific table (e.g. pivot table):
```php
DB::table('role_user')->insert([ 'user_id' => 1, 'role_id' => 1])
```

Test relationship:
```php
$user = App\User::find(1);
$user->posts
```