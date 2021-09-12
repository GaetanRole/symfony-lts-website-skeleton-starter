<p><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_black_02.svg" alt="symfony logo">
</a></p>

# symfony-lts-website-skeleton-starter

**This repository is useful for beginners.**
I created a starter kit for Symfony 4.4 (LTS), based on the website-skeleton project provided by Symfony itself. This one is more complete to start a real project.

It shows how to use [WebpackEncore][1], [TimeContinuum][2], [User Auth][3] and other stuffs (such as a Makefile, fixtures, Unit and Functional tests, Behat, Bootstrap (Sass/JQuery), Stimulus, Guard, Events, Entity traits, Q&A tools, translations, commands...) **following the recommended SensioLabs best practices**.

![Software License](https://img.shields.io/badge/php-8.0-brightgreen.svg)

[![Author](https://img.shields.io/badge/author-gaetan.role%40gmail.com-blue.svg)](https://github.com/gaetanrole)

## Installation instructions

### Project requirements

- [PHP >=7.2.5 or higher](http://php.net/manual/fr/install.php)
- [Symfony CLI](https://symfony.com/download)
- [Composer](https://getcomposer.org/download)
- [Yarn](https://yarnpkg.com/lang/en/)
- and the [usual Symfony application requirements][4].

### Project view

![Alt text](symfony_starter_kit_readme_screenshot.png?raw=true "Default page")

### Installation

1 . Clone the current repository:
```bash
$ git clone 'https://github.com/GaetanRole/symfony-lts-website-skeleton-starter'
```

2 . Move in and create few `.env.{environment}.local` files, according to your environments with your default configuration
or only one global `.env.local`. **This one is not committed to the shared repository.**
> `.env` equals to the last `.env.dist` file before [november 2018][5].

3.a . Execute commands below into your working folder to install the project:
```bash
$ composer install
$ yarn install
$ yarn run dev
$ bin/console doctrine:database:create # (d:d:c)
$ bin/console doctrine:migration:migrate # (d:m:m)
$ bin/console doctrine:fixtures:load # (d:f:l)
$ bin/console doctrine:migration:status # (d:m:st)
```

3.b . Or just set your DATABASE_URL and call the Makefile's install rule:
```bash
$ make install
```

> The project's Makefile has few rules which could be very useful.
> In fact, you have some rules for Q&A tools and unit/functional tests.
> Take a look on it !

## Usage

```bash
$ cd symfony-lts-website-skeleton-starter
$ symfony server:start --no-tls
```

> The web server bundle is no longer used anymore. Use the Symfony [binary][6] now.

For loading User's [fixture][7] (fixture based on default locale):

```bash
$ bin/console doctrine:fixture:load
```

For [translation][8] to XLIFF files (app_locales: ['fr', '%locale%']):

```bash
$ bin/console translation:update --output-format xlf --dump-messages --force en
$ bin/console translation:update --output-format xlf --dump-messages --force fr
```

To use [PHP CodeSniffer][9] (for more PHPDocumentor usage, see official [https://docs.phpdoc.org/]):

```bash
$ ./vendor/bin/phpcbf src/[FILE]
$ ./vendor/bin/phpcs src/[FILE]
```

To see all available routes:

```bash
$ bin/console debug:router
```

To see all services:

```bash
$ bin/console debug:container
```

## User

Current [User][10] entity has some fields that are required or not.
Feel free to change it according to your logic, such as adding canonical fields, salt and others:

```bash
$ bin/console make:entity User
```

And do not forget to update your User's fixture:

```bash
$ bin/console doctrine:fixture:load
```

## Personal commands

To use a personal [command][11] (displaying all users from DB):

```bash
$ bin/console app:list-users --help
$ bin/console app:list-users
```

Feel free to create other commands such as a promotion command or a user creation...

## Tests

Execute this command to run PHPUnit and Behat tests:

```bash
$ make tests
```

[1]: https://symfony.com/doc/current/frontend.html
[2]: https://github.com/Innmind/TimeContinuum
[3]: https://symfony.com/doc/current/security/form_login_setup.html
[4]: https://symfony.com/doc/current/reference/requirements.html
[5]: https://symfony.com/doc/current/configuration.html#the-env-file-environment-variables
[6]: https://symfony.com/doc/current/setup/symfony_server.html
[7]: https://symfony.com/doc/current/doctrine.html#doctrine-fixtures
[8]: https://symfony.com/doc/current/translation.html
[9]: https://github.com/squizlabs/PHP_CodeSniffer
[10]: https://symfony.com/doc/current/security.html
[11]: https://symfony.com/doc/current/console.html

## Contributing

Do not hesitate to improve this repository, by creating your PR on GitHub with a description which explains it.

Ask your question on `gaetan.role@gmail.com`.
