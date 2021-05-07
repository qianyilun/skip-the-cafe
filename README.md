## Instructions
1. Make sure `php artisan` is working on your dev envrionment

2. (For Windows) run `php artisan migrate:fresh --seed` to clean the database, applies all migrations and then seeds the database
    * Related directories: 
        * `\database\migrations`
        * `\database\seeds`
        * `\database\factories`

3. You should be able to view orders from database in the homepage now


## Enviroment Setup (for Windows)
1. Use `Laravel Homestead`

2. In `Homestead.yaml`:
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


## Enviroment Setup (for Mac)

1. Run `composer install` in the project root, since the master branch does not automatically include all dependencies 

2. Use `Laravel Homestead`

3. In `Homestead.yaml`:

   ```yaml
   folders:
       - map: your path
       to: your path
   sites:
       - map: skipthecafe.test
       to: /home/vagrant/Code/skip-the-cafe/public
   ```

4. In host file `sudo nano /etc/hosts`

   ```
   192.168.10.10 skipthecafe.test
   ```

5. Start your Vagrant

6. Cd to skip-the-cafe root path

7. Check mysql `mysql -u homestead -p` and the password is `secret`

8. `show databases;` to check if you have `homestead` database

9. Run `php artisan migrate:fresh --seed`

10. Under Homestead folder, run `vagrant up`

11. Start server `php artisan serve` 

12. Open up browser, visit [skipthecafe.test](skipthecafe.test)



