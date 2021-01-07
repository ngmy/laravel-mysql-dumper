# Laravel MySQL Dumper

[![Latest Stable Version](https://poser.pugx.org/ngmy/laravel-mysql-dumper/v/stable)](https://packagist.org/packages/ngmy/laravel-mysql-dumper)
[![Total Downloads](https://poser.pugx.org/ngmy/laravel-mysql-dumper/downloads)](https://packagist.org/packages/ngmy/laravel-mysql-dumper)
[![Latest Unstable Version](https://poser.pugx.org/ngmy/laravel-mysql-dumper/v/unstable)](https://packagist.org/packages/ngmy/laravel-mysql-dumper)
[![License](https://poser.pugx.org/ngmy/laravel-mysql-dumper/license)](https://packagist.org/packages/ngmy/laravel-mysql-dumper)
[![composer.lock](https://poser.pugx.org/ngmy/laravel-mysql-dumper/composerlock)](https://packagist.org/packages/ngmy/laravel-mysql-dumper)<br>
[![PHP CI](https://github.com/ngmy/laravel-mysql-dumper/workflows/PHP%20CI/badge.svg)](https://github.com/ngmy/laravel-mysql-dumper/actions?query=workflow%3A%22PHP+CI%22)
[![Coverage Status](https://coveralls.io/repos/github/ngmy/laravel-mysql-dumper/badge.svg?branch=master)](https://coveralls.io/github/ngmy/laravel-mysql-dumper?branch=master)

The Laravel package that provides the Artisan command to execute `mysqldump`.

## Features

Laravel MySQL Dumper has the following features:

* Dump all the database from the MySQL database
* Dump only the data from the MySQL database
* Dump only the schema from the MySQL database
* Dump from the MySQL database with your dump setting, such as `mysqldump` options

## Requirements

Laravel MySQL Dumper has the following requirements:

* PHP >= 7.3
* Laravel >= 6.0

## Installation

Execute the Composer `require` command:
```console
composer require ngmy/laravel-mysql-dumper
```
This will update your `composer.json` file and install this package into the `vendor` directory.

If you don't use package discovery, add the service provider to the `providers` array in the `config/app.php` file:
```php
Ngmy\LaravelMysqlDumper\MysqlDumperServiceProvider::class,
```

### Publishing Configuration

Execute the Artisan `vendor:publish` command:
```console
php artisan vendor:publish
```
This will publish the configuration file to the `config/ngmy-mysql-dumper.php` file.

You can also use the tag to execute the command:
```console
php artisan vendor:publish --tag=ngmy-mysql-dumper
```

You can also use the service provider to execute the command:
```console
php artisan vendor:publish --provider="Ngmy\LaravelMysqlDumper\MysqlDumperServiceProvider"
```

## Usage

### Dump All the Database

```console
php artisan mysql-dumper:dump
```

### Dump Only the Schema

```console
php artisan mysql-dumper:dump --setting=schema
```

### Dump Only the Data

```console
php artisan mysql-dumper:dump --setting=data
```

### Dump with Your Dump Setting
Add the dump setting to the `settings` array in the `config/ngmy-mysql-dumper.php` file.<br>
Then, use the dump setting to execute the command:
```console
php artisan mysql-dumper:dump --setting=your_setting
```

### Dump to Import with Laravel
Use the dump setting with the `importalbe_with_laravel` option `true` to execute the command:
```console
php artisan mysql-dumper:dump
```
Then, use the `unprepared` method to import the dump file, such as in your migration.
```php
DB::unprepared(file_get_contents($dumpFile));
```
