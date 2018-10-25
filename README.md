## Instructions
0. run `composer install` in the project root, since the master branch does not automatically include all dependencies 
1. make sure `php artisan` is working on your dev envrionment
2. run `php artisan migrate:fresh --seed` to clean the database, applies all migrations and then seeds the database
    * Related directories: 
        * `\database\migrations`
        * `\database\seeds`
        * `\database\factories`
3. You should be able to view orders from database in the homepage now

## Enviroment Setup (for windows)
1. Use Laravel Homestead
2. In HomeStead.yaml:
    ```yaml
    folders:
        - map: D:\PHPDevelop\laravel-apps
        to: /home/vagrant/Code
    sites:
        - map: skipthecafe.test
        to: /home/vagrant/Code/skip_the_cafe/public
    ```
    You can decide your own directory for folders
3. In host file
    ```
    192.168.10.10 skipthecafe.test
    ```
4. Under Homestead folder, run `vagrant up`
5. Open up browser, visit [skipthecafe.test](skipthecafe.test)