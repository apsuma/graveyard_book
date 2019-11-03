# GraveyardBook

## Description

This repository is based on PHP MVC structure. The structure is a reused from Simple_MVC by WCS, adapted for this personnal project. 
It' a CRUD about a Neil Gaiman's book : Graveyard Book. 

It works with a database. A script database.sql will be joined on next version to create this database as you want.
It's about the characters of the book. You can find a note about each character (picture, name, status, description).
You can add Characters, modify or delete the notes about Characters.
In a further version, it will be possible to link Character and quotes from the book. 


## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```
4. Import `database.sql` in your SQL server (as soon as it will be available),
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.
7. From this starter kit, create your try this web application.

### Context
It's a student project made with PHP7.2 and using model MVC and twig, html5, CSS3 and sql to communicate with database.
