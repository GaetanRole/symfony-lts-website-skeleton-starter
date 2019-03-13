<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

Symfony 4 starter kit
=====================

I created a starter kit for Symfony 4 to show how to use [WebpackEncore][1], [TimeContinuum][2], [User Auth][3]
and so on (such as Fixtures (Faker), GuardAuthenticator, Security:checker, RememberIn, Translations, Commands ...),
following the recommended best practices.
User auth is based on Symfony form login authentication.

Requirements
------------

  * Php ^7.1.3    http://php.net/manual/fr/install.php;
  * Composer    https://getcomposer.org/download/;
  * NPM         https://www.npmjs.com/get-npm (or `sudo apt install nodejs npm`);
  * and the [usual Symfony application requirements][4].

Installation
------------

1 . Clone the current repository.

2 . Move in and create few `.env.{environment}.local` files according to your environments with your default configuration
or only one global `.env.local`. **This one is not committed to the shared repository.**
 
> `.env` equals to the last `.env.dist` file before [november 2018][5].

3 .a. Execute commands below into your working folder to install the project :

```bash
$ composer install
$ composer update
$ npm install
$ npm run-script dev
$ bin/console d:d:c (create the project's DB)
$ bin/console d:m:m (run the migration, always commit)
$ bin/console d:m:s (check if everything is updated)
```
3 .b. Or execute a simple shell script if your DB is already set up :

```bash
$ ./install-dependencies.sh
```

Usage
-----

```bash
$ bin/console s:r
$ bin/console c:c --env=dev
```

For loading User's [fixture][6] (fixture based on default locale) :
```bash
$ bin/console d:f:l
```

For [translation][7] to XLIFF files (`app_locales: en|fr`) :

```bash
$ bin/console translation:update --output-format xlf --dump-messages --force en
$ bin/console translation:update --output-format xlf --dump-messages --force fr
```

To use [PHP CodeSniffer][8] (for more PHPDocumentor usage, see official [https://docs.phpdoc.org/]):

```bash
$ ./vendor/bin/phpcbf src/[FILE]
$ ./vendor/bin/phpcs src/[FILE]
```

To see all available routes :
```bash
$ bin/console d:r
```

To see all services :
```bash
$ bin/console d:c
```

User
-----

Current [User][9] entity has some fields that are required or not.
Feel free to change it according to your logic, such as adding canonical fields, salt, plainPassword, lastLogin and others : 
```bash
$ bin/console make:entity
$ User
```

And do not forget to update your User's fixture :
```bash
$ bin/console d:f:l
```

Personal commands
-----
To use a personal sample [command][10] (displaying all users from DB) :

```bash
$ bin/console app:list-users --help
$ bin/console app:list-users
```

Do not hesitate to create other commands such as a promotion command or a user creation ...

Personal routes
-----
- `{SERVER_HOST}/`
- `{SERVER_HOST}/login`
- `{SERVER_HOST}/logout`
- `{SERVER_HOST}/profile` (granted for [ROLE_USER])

Screenshot
-----
![Alt text](symfony_starter_kit_readme_screenshot.png?raw=true "Default page")

[1]: https://symfony.com/doc/current/frontend.html
[2]: https://github.com/Innmind/TimeContinuum
[3]: https://symfony.com/doc/current/security/form_login_setup.html
[4]: https://symfony.com/doc/current/reference/requirements.html
[5]: https://symfony.com/doc/current/configuration.html#the-env-file-environment-variables
[6]: https://symfony.com/doc/current/doctrine.html#doctrine-fixtures
[7]: https://symfony.com/doc/current/translation.html
[8]: https://github.com/squizlabs/PHP_CodeSniffer
[9]: https://symfony.com/doc/current/security.html
[10]: https://symfony.com/doc/current/console.html

13/03/2018 gaetan.role@gmail.com
