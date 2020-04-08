# Laravel MySQL Dumper

The Laravel package that provides the Artisan command to execute `mysqldump`.

## Features

Laravel MySQL Dumper has the following features:

* Dump all the database from the MySQL database
* Dump only the data from the MySQL database
* Dump only the schema from the MySQL database
* Dump from the MySQL database with your dump setting, such as `mysqldump` options

## Requirements

Laravel MySQL Dumper has the following requirements:

* PHP >= 7.2
* Laravel >= 5.5

## Installation

Execute the Composer `require` command:
```
composer require ngmy/laravel-mysql-dumper
```
This will update your `composer.json` file and install this package into the `vendor` directory.

If you don't use package discovery, add the service provider to the `providers` array in the `config/app.php` file:
```php
Ngmy\LaravelMysqlDumper\MysqlDumperServiceProvider::class,
```

### Publishing Configuration

Execute the Artisan `vendor:publish` command:
```
php artisan vendor:publish
```
This will publish the configuration file to the `config/ngmy-mysql-dumper.php` file.

You can also use the tag to execute the command:
```
php artisan vendor:publish --tag=ngmy-mysql-dumper
```

You can also use the service provider to execute the command:
```
php artisan vendor:publish --provider="Ngmy\LaravelMysqlDumper\MysqlDumperServiceProvider"
```

## Usage

### Dump All the Database

```
php artisan mysql-dumper:dump
```

### Dump Only the Schema

```
php artisan mysql-dumper:dump --setting=schema
```

### Dump Only the Data

```
php artisan mysql-dumper:dump --setting=data
```

### Dump with Your Dump Setting
Add the dump setting to the `settings` array in the `config/ngmy-mysql-dumper.php` file.<br>
Then, use the dump setting to execute the command:
```
php artisan mysql-dumper:dump --setting=your_setting
```

### Dump to Import with Laravel
Use the dump setting with the `importalbe_with_laravel` option `true` to execute the command:
```
php artisan mysql-dumper:dump
```
Then, use the `unprepared` method to import the dump file, such as in your migration.
```php
DB::unprepared(file_get_contents($dumpFile));
```
