<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

Symfony 4 starter kit
=====================

I created a starter kit for Symfony 4 to show how to use [WebpackEncore][1], [TimeContinuum][2], [User Auth][3]
and so on, following the recommended best practices.

Requirements
------------

  * Php ^7.2    http://php.net/manual/fr/install.php;
  * Composer    https://getcomposer.org/download/;
  * NPM         https://www.npmjs.com/get-npm;
  * and the [usual Symfony application requirements][4].

Installation
------------

Execute this command into your working folder to install the project:

```bash
$ composer install
$ composer update
$ npm install
$ npm run-script dev
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

[1]: https://symfony.com/doc/current/frontend.html
[2]: https://github.com/Innmind/TimeContinuum
[3]: https://symfony.com/doc/current/security/form_login_setup.html
[4]: https://symfony.com/doc/current/reference/requirements.html
[5]: https://github.com/squizlabs/PHP_CodeSniffer

16/11/2018 gaetan@wildcodeschool.fr