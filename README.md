Pegmata
============

# Description
A MVC framework for creating web applications.

## Prerequisites
+ HTTP server like Apache or Nginx
+ PHP support
+ Composer which manages packages regarding PHP
+ MySQL server

## Installation
At first, clone or download this project. Afterwards, go to the folder `libs` and execute the following commands:
```
$ curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
$ composer install
```
The composer installs required packages based on the `composer.json` in the folder `vendor`. The next step is to import the SQL file, for example:
```
$ mysql -h localhost -u myname -pmypass
mysql> CREATE DATABASE dbname;
mysql> USE dbname;
mysql> SET autocommit=0; source pegmata.sql; COMMIT;
mysql> EXIT
```
After the import, go to `res/etc`, open the file `prod.php` and edit the database settings.
```
## Usage
For a better understanding, there are an example which uses this database. Explore the controllers (`PagesController`), models (`Pages`) and views (`pages/index.html`) regarding the backend and frontend. Otherwise, you're able to checkout this interaction in the user agent (`/pages`). At the moment, Pegmata supports:
+ MVC
+ i18n
+ Logging
+ Session Handling
+ Database Operations
+ Template Engine
+ Validation

## Note
In this framework, the module `mod_rewrite` is required. This module uses a rule-based rewriting engine, based on a PCRE regular-expression parser, to rewrite requested URLs on the fly. You have to install and activate it, for example in the `httpd.conf` with the following code:
```
...
LoadModule rewrite_module modules/mod_rewrite.so
...
```

## More information
If you need a documentation, go to the root folder and execute the following commands:

```
$ phpdoc -d path_to_the_root_folder -t path_to_the_doc_folder --title "Pegmata"
```
Afterwards, you will get a website with helpful information about the code.