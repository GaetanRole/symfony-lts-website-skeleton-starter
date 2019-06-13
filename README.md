<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg">
</a></p>

# Symfony-website-skeleton-starter

I created a starter kit for Symfony 4, based on the website-skeleton provided by Symfony itself, to show how to use [WebpackEncore][1], [TimeContinuum][2], [User Auth][3]
and so on (such as fixtures by Faker, guardAuthenticator, security:checker, unit and functional tests, Q&A tools, translations, commands ...),
**following the recommended SensioLabs best practices**.
User auth is based on Symfony form login authentication.

**This repository is useful for beginners.**

## Installation instructions

### Project requirements

- [PHP ^7.1.3](http://php.net/manual/fr/install.php)
- [Composer](https://getcomposer.org/download)
- [Yarn](https://yarnpkg.com/lang/en/)
- and the [usual Symfony application requirements][4].

### Project view

![Alt text](symfony_starter_kit_readme_screenshot.png?raw=true "Default page")

### Installation

1 . Clone the current repository.

2 . Move in and create few `.env.{environment}.local` files, according to your environments with your default configuration
or only one global `.env.local`. **This one is not committed to the shared repository.**
 
> `.env` equals to the last `.env.dist` file before [november 2018][5].

3 .a. Execute commands below into your working folder to install the project :

```bash
$ composer install
$ composer update
$ yarn install
$ yarn run dev
$ bin/console doctrine:database:create
$ bin/console doctrine:migration:migrate
$ bin/console doctrine:migration:secure
```
3 .b. Or just set your DATABASE_URL and call the Makefile's install rule :

```bash
$ make install
```

> The project's Makefile has few rules which could be very useful. 
> In fact, you have some rules for Q&A tools and unit/functional tests.
> Take a look on it !

## Usage

```bash
$ bin/console server:run
$ make start
```

For loading User's [fixture][6] (fixture based on default locale) :

```bash
$ bin/console doctrine:fixture:load
```

For [translation][7] to XLIFF files (app_locales: ['fr', '%locale%']) :

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
$ bin/console debug:router
```

To see all services 

```bash
$ bin/console debug:container
```

## User

Current [User][9] entity has some fields that are required or not.
Feel free to change it according to your logic, such as adding canonical fields, salt, lastLogin and others : 

```bash
$ bin/console make:entity
$ User
```

And do not forget to update your User's fixture :

```bash
$ bin/console doctrine:fixture:load
```

## Personal commands

To use a personal [command][10] (displaying all users from DB) :

```bash
$ bin/console app:list-users --help
$ bin/console app:list-users
```

Feel free to create other commands such as a promotion command or a user creation ...

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

## Contributing

Do not hesitate to improve this repository, by creating your PR on GitHub with a description which explains it.

Ask your question on `gaetan.role-dubruille@sensiolabs.com`.
