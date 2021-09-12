CONSOLE				= bin/console
# A little hack if you want increase Composer memory
# COMPOSER			= php -d memory_limit=-1 /usr/local/bin/composer
COMPOSER			= composer
PHPUNIT				= SYMFONY_PHPUNIT_VERSION=9.5.9 bin/phpunit
YARN				= yarn

##
###------------#
###    Help    #
###------------#
##

.DEFAULT_GOAL := 	help

help:				## Display all help messages
					@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.PHONY: 			help

##
###---------------------------#
###    Project commands (SF)  #
###---------------------------#
##

install:			.env.local vendor node_modules assets db-init ## Launch project : copy the env and start the project with vendors, assets and DB

install-prod:		.env.local
					sed -i -E s/APP_ENV=[a-zA-Z]+/APP_ENV=prod/ .env.local
					$(COMPOSER) install --no-dev --optimize-autoloader
					$(YARN) install --production
					$(YARN) run build
					$(CONSOLE) cache:clear --env=prod

sf-console\:%:		## Calling Symfony console
					$(CONSOLE) $* $(ARGS)

.PHONY:				install install-prod

##
###-------------------------#
###    Doctrine commands    #
###-------------------------#
##

db-wait: 			## Wait for database to be up. Looking DATABASE_URL
					php -r 'echo "Wait database... Be sure of your DATABASE_URL config, if not, rerun make install.\n"; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$u = parse_url(getenv("DATABASE_URL")); for(;;) { if(@fsockopen($$u["host"].":".($$u["port"] ?? 3306))) { break; }}'

db-destroy: 		## Execute doctrine:database:drop --force command
					$(CONSOLE) doctrine:database:drop --force --if-exists
					$(CONSOLE) doctrine:database:drop --force --env=test

db-create:			## Execute doctrine:database:create
					$(CONSOLE) doctrine:database:create --if-not-exists -vvv

db-migrate:			## Execute doctrine:migrations:migrate
					$(CONSOLE) doctrine:migrations:migrate --allow-no-migration --no-interaction --all-or-nothing

db-fixtures: 		## Execute doctrine:fixtures:load
					$(CONSOLE) doctrine:fixtures:load --no-interaction
					$(CONSOLE) app:list-users

db-fixtures-test: 	## Execute doctrine:fixtures:load fo test env
					$(CONSOLE) doctrine:database:create -vvv --env=test
					$(CONSOLE) doctrine:migrations:migrate --allow-no-migration --no-interaction --all-or-nothing --env=test
					$(CONSOLE) doctrine:fixtures:load --no-interaction --env=test

db-diff:			## Execute doctrine:migration:diff
					$(CONSOLE) doctrine:migrations:diff --formatted

db-validate:		## Validate the doctrine ORM mapping
					$(CONSOLE) doctrine:schema:validate

db-init:			vendor db-wait db-create db-migrate db-fixtures db-fixtures-test ## Initialize database e.g : wait, create database, migrations and load fixtures (dev and test env)

db-update: 			vendor db-diff db-migrate ## Alias coupling db-diff and db-migrate

.PHONY: 			db-wait db-destroy db-create db-migrate db-fixtures db-fixtures-test db-diff db-validate db-init db-update

##
###----------------------------#
###    Rules based on files    #
###----------------------------#
##

vendor:				./composer.json ## Install dependencies (vendor) (might be slow)
					@echo 'Might be very slow for the first launch.'
					$(COMPOSER) install --prefer-dist --no-progress

node_modules:		./package.json ## Yarn install
					$(YARN) install --frozen-lockfile

.env.local:			./.env ## Create env.local
					@echo '\033[1;42m/\ The .env.local was just created. Feel free to put your config in it.\033[0m';
					cp ./.env ./.env.local;

##
###------------#
###    Utils   #
###------------#
##

cc:					## Clear cache
					$(CONSOLE) cache:clear

cc-prod:			## Clear cache for prod
					$(CONSOLE) cache:clear --env=prod

assets:				node_modules ## Install node_modules and compile with Yarn
					$(YARN) run dev

watch:				node_modules ## Install node_modules and compile with Yarn with watch option
					$(YARN) run watch

clear-assets:		## Remove build directory
					rm -rvf ./public/build

clean:				qa-clean-conf ## Remove all generated files
					rm -rvf ./vendor ./node_modules ./var
					rm -rvf ./bin/.phpunit ./behat.yml

clear:				db-destroy clear-assets clean ## Remove all generated files and db

update:				node_modules ## Update dependencies
					$(COMPOSER) update --lock --no-interaction
					$(YARN) upgrade

update-prod:		## Update dependencies for prod
					$(COMPOSER) update --no-dev --optimize-autoloader
					$(CONSOLE) cache:clear --env=prod
					$(COMPOSER) dump-autoload --optimize --no-dev --classmap-authoritative
					# sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log
                    # sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log

.PHONY:				cc cc-prod assets watch clear-assets clean clear update update-prod

##
###-------------------#
###    PhpUnit Tests  #
###-------------------#
##

tu:					vendor ## Run unit tests (might be slow for the first time)
					$(PHPUNIT) --exclude-group functional

tf:					vendor ## Run functional tests
					$(PHPUNIT) --group functional

tw:					vendor ## Run wip tests
					$(PHPUNIT) --group wip

coverage:			vendor ## Run code coverage of PHPunit suite
					$(PHPUNIT) --coverage-html ./var/coverage

phpunit: 			tu tf tw coverage ## Alias coupling all PHPUnit tests

.PHONY:				tu tf tw coverage phpunit

##
###-----------------------#
###    Functional Tests   #
###-----------------------#
##

behat.yml:			./behat.yml.dist ## Create behat.yml based on the dist one
					cp ./behat.yml.dist ./behat.yml

behat: 				behat.yml vendor  ## Run fonctionnal tests using behat
					./vendor/bin/behat --stop-on-failure

behat-wip:			behat.yml vendor ## Run fonctionnal tests using behat having tags=wip
					./vendor/bin/behat --tags=wip

.PHONY:				behat behat-wip

##
###----------------#
###    Q&A tools   #
###----------------#
##

lt:					vendor ## Lint twig templates
					$(CONSOLE) lint:twig ./templates

ly:					vendor ## Lint yaml conf files
					$(CONSOLE) lint:yaml ./config

lc:					vendor ## Ensures that arguments injected into services match type declarations
					$(CONSOLE) lint:container

lint:				lt ly lc ## Lint twig and yaml files

.PHONY:				lt ly lc lint

##
###----------------------#
###    PHP Code Sniffer  #
###----------------------#
##

phpcs.xml:			./phpcs.xml.dist ## Create phpcs.xml based on the dist one
					cp ./phpcs.xml.dist ./phpcs.xml

phpcs: 				phpcs.xml vendor ## Execute PHP Code Sniffer
					./vendor/bin/phpcs -v ./src --ignore=src/Migrations/

phpcbf: 			phpcs.xml vendor ## Execute PHP Code Sniffer
					./vendor/bin/phpcbf -v ./src

.PHONY: 			phpcs phpcbf

##
###--------------#
###    PHP LOC   #
###--------------#
##

phploc:				vendor ## PHPLoc (https://github.com/sebastianbergmann/phploc)
					./vendor/bin/phploc ./src

.PHONY: 			phploc

##
###--------------#
###    PHP CPD   #
###--------------#
##

phpcpd:				vendor ## PHPCPD (https://github.com/sebastianbergmann/phpcpd)
					./vendor/bin/phpcpd ./src

.PHONY: 			phpcpd

##
###----------------------#
###    PHP Mess Detector #
###----------------------#
##

phpmd.xml:			./phpmd.xml.dist ## Create phpmd.xml based on the dist one
					cp ./phpmd.xml.dist ./phpmd.xml

phpmd: 				phpmd.xml vendor ## PHPMD (https://github.com/phpmd/phpmd)
					./vendor/bin/phpmd ./src text phpmd.xml

.PHONY: 			phpmd

##
###-----------------------#
###    Tests / Q&A Alias  #
###-----------------------#
##

qa-clean-conf:		## Erasing all quality assurance conf files
					rm -rvf ./.php_cs ./phpcs.xml ./.phpcs-cache ./phpmd.xml ./.phpunit.result.cache

qa: 				lt ly lc phpcs phpcbf phploc phpcpd phpmd ## Alias to run/apply Q&A tools

tests: 				phpunit behat ## Alias coupling all PHPUnit tests and Behat

.PHONY:				qa-clean-conf qa tests
