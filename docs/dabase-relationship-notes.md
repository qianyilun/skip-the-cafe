# Database Relationships
## One to one relationship:
We use User, Post, and Role as example 

(in `User.php`)
```php
public function post() {  
    return $this->hasOne('App\Post');  
}
```
by doing this it tries to look for `user_id` in the Post by default, we can also specify the specific column by add the second parameter to this method
we can access a post of a user using
```php
App\User::find(1)->post->title;
```
(This is laravel feature that it makes methods `post()` to be accessed as preperties `post`)
To do the reverse relationship (post -> user)
(in `Post.php`)
```php
public function user() {  
    return $this->belongsTo('App\User');  
}
```
we can access the user using
```php
App\Post::find(1)->user->name;
```
To have access to all posts of a user
```php
App\User::find(1)->post->all()
```
## One to many relationship
(in `User.php`)
```php
public function posts() {  
    return $this->hasMany('App\Post');  
}
```
we can access the posts of a user using
```php
App\User::find(1)->posts;
```
## Many to many relationship
For this relationship we need to construct pivot table: a lookup table, we use it to relate other tables
To create a pivot table of users and roles, wo need to singularize the name and follow alphabetic order: `php artisan make:migration create_users_roles_table --create=role_user`
In the `role_user` migration, we need to add
```php
$table->integer('user_id');  
$table->integer('role_id');
```
to relate user table and role table by their ids
And in `User.php`
```php
public function roles() {  
    return $this->belongsToMany('App\Role');  
}
```
To query all the roles from a user:
```php
User::find($id)->roles()->orderBy('id','desc')->get();
