<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

Symfony 4 starter kit
=====================

I created a starter kit for Symfony 4 to show how to use [WebpackEncore][1], [TimeContinuum][2], [User Auth][3]
and so on, following the recommended best practices.
User auth is based on Symfony form login authentication with Guard.

Requirements
------------

  * Php ^7.2    http://php.net/manual/fr/install.php;
  * Composer    https://getcomposer.org/download/;
  * NPM         https://www.npmjs.com/get-npm;
  * and the [usual Symfony application requirements][4].

Installation
------------

1. Create few `.env.{environnement}.local` files with your default configuration or only one global `.env.local`.
 **This one is not committed to the shared repository.**
 
> `.env` equals to the last `.env.dist` file before november 2018.

2. Execute this command into your working folder to install the project:

```bash
$ composer install
$ composer update
$ npm install
$ npm run-script dev
$ bin/console d:d:c (create the project's DB)
$ bin/console m:m (make migration)
$ bin/console d:m:m (run the migration)
$ bin/console d:m:s (check if everything is updated)
```

Usage
-----

```bash
$ bin/console s:r
$ bin/console c:c
```

For translation to XLIFF files :
```bash
$ bin/console translation:update --output-format xlf --dump-messages --force en
```

To use [PHP CodeSniffer][5] :
```bash
$ ./vendor/bin/phpcbf src/[FILE]
$ ./vendor/bin/phpcs src/[FILE]
```

User
-----

Current [User][6] entity has some fields that are required or not.
Feel free to change it according to your logic, such as adding canonical fields, salt, plainPassword, lastLogin and others  : 
```bash
$ bin/console make:entity
$ User
```

Before migration, 

[1]: https://symfony.com/doc/current/frontend.html
[2]: https://github.com/Innmind/TimeContinuum
[3]: https://symfony.com/doc/current/security/form_login_setup.html
[4]: https://symfony.com/doc/current/reference/requirements.html
[5]: https://github.com/squizlabs/PHP_CodeSniffer
[6]: https://symfony.com/doc/current/security.html

16/11/2018 gaetan@wildcodeschool.fr