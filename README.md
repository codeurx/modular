# Codeurx Modular
<p align="center">
<a href="https://packagist.org/packages/codeurx/modular"><img src="https://img.shields.io/github/license/codeurx/modular.svg" alt="License"></a>
<a href="https://travis-ci.org/codeurx/modular"><img src="https://travis-ci.org/codeurx/modular.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/codeurx/modular"><img src="https://img.shields.io/packagist/v/codeurx/modular.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/codeurx/modular"><img src="https://scrutinizer-ci.com/g/codeurx/modular/badges/quality-score.png?b=v2.2" alt="Scrutinizer Code Quality"></a>
</p>

Codeurx Modular is simply a package for Laravel to help you create and manage modules.

## Install

To install through Composer, by run the following command:

``` bash
composer require codeurx/modular
```

### Autoloading

By default the module classes are not loaded automatically. You can autoload your modules using `psr-4`. For example:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "App\\Modules\\": "app/Modules/"
    },
    "files": [
        "app/Modules/helpers/helpers.php"
    ]
  }
}
```

**Tip: don't forget to run `composer dump-autoload` afterwards.**

run the following command to publish `modules` table migrations:

```
php artisan vendor:publish --provider="Codeurx\Modular\ModularServiceProvider" --tag="migrations"
```

after that run the command:

```
php artisan migrate
```

## Usage

**Creating A Module**

To create a new module, simply run the following command:
``` bash
php artisan modular:make <module-name>
```
- `<module-name>` - Replace with the name of the desired module.

**Folder Structure**
```
app/Modules/
      ├── Users/
          ├─ Database/
             ├─ Migrations/
          ├─ Http/
             ├─ Controllers/
                ├─ UsersController.php
             ├─ Models/
                ├─ UsersModel.php
          ├─ Providers/
             ├─ UsersServiceProvider.php
          ├─ Resources/
             ├─ views/
                ├─ index.blade.php
          ├─ Routes/
             ├─ web.php 
      
```

You can access the url example for Users module by typing :
```
http://sever/users/ or  http://sever/public/users/
```

For Dummy data:
```
http://sever/users/users-test or  http://sever/public/users/users-test
```

**Deleting A Module**

To delete a specific module, simply run the following command:
``` bash
php artisan modular:delete <module-name>
```
- `<module-name>` - Replace with the name of the desired module to be deleted.

**Tip: if the module does not exist you will be asked if you want to create it.**

**Listing All the Modules**

To list the modules just run the following command:

``` bash
php artisan modular:list
```

**Creating A Module Migration**

To create a migration for a specific module just run the following command:

``` bash
php artisan modular:make-migration <module-name> --table=<table-name>
```
 - `<module-name>` - Replace with the name of the desired module.
 - `<table-name>` - optional field, replace it with a disired name of table.
 
**if you don't give the option --table the table name will take the name of the module by default.**
 
**Migrating Database for all modules**

 ``` bash
 php artisan modular:migrate
 ```
 
**Migrating Database for specific module**
 
 ``` bash
 php artisan modular:migrate <module-name>
 ```
 
 **Creating a new Controller for specific module**
  
  ``` bash
  php artisan modular:make-controller <module-name> <controller-name>
  ```

- `<module-name>` - Replace with the name of the desired module.
- `<controller-name>` - Replace with the controller name.

For example :

``` bash
  php artisan modular:make-controller users TestController
  ```
or
 
``` bash
  php artisan modular:make-controller users Test/TestController
  ```
**Tip: if you typed the second command the folder structure will be like below :**

```
app/Modules/
      ├── Users/
          ├─ Database/
             ├─ Migrations/
          ├─ Http/
             ├─ Controllers/
                ├─ Test 
                   ├─ TestController.php
                ├─ UsersController.php
             ├─ Models/
                ├─ UsersModel.php
          ├─ Providers/
             ├─ UsersServiceProvider.php
          ├─ Resources/
             ├─ views/
                ├─ index.blade.php
          ├─ Routes/
             ├─ web.php 
      
```

And for the routes you should add a line like this :

```
<?php

/*
|--------------------------------------------------------------------------
| Users Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the Users module have to go in here. 
|
*/

Route::get('/', 'UsersController@index');
Route::get('/users-test', 'UsersController@UsersTest');
Route::get('/test', 'Test\TestController@index');
```

**Creating a new model for specific module**
  
  ``` bash
  php artisan modular:make-model <module-name> <model-name>
  ```

- `<module-name>` - Replace with the name of the desired module.
- `<model-name>` - Replace with the model name.

For example :

``` bash
  php artisan modular:make-model users TestModel
  ```
or
 
``` bash
  php artisan modular:make-model users Test/TestModel
  ```
**Tip: if you typed the second command the folder structure will be like below :**

```
app/Modules/
      ├── Users/
          ├─ Database/
             ├─ Migrations/
          ├─ Http/
             ├─ Controllers/
                ├─ UsersController.php
             ├─ Models/
                ├─ Test 
                   ├─ TestModel.php
                ├─ UsersModel.php
          ├─ Providers/
             ├─ UsersServiceProvider.php
          ├─ Resources/
             ├─ views/
                ├─ index.blade.php
          ├─ Routes/
             ├─ web.php 
      
```

## Credits

- [Amir Ali Salah](https://github.com/codeurx)

## About Amir Ali Salah

I'm a Tunisian FullStack Web Developer. For the moment i work for GIS (Gate Informatic Systems), you can visit [My Website](http://amir-ali.eb2a.com) for more Informations.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
