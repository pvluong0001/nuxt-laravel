UID := $(shell id -u)

start: composer_install up
up:
	docker-compose up
init: build composer_install
migrate:
	docker-compose exec api php artisan migrate
migrate_with_seed:
	docker-compose exec api php artisan migrate --seed
dump_autoload:
	docker-compose run --rm composer dump-autoload
composer_install:
	docker-compose run --rm composer composer install
build:
	docker-compose build
unit_test:
	docker-compose exec api ./vendor/bin/phpunit --coverage-html _coverage
phpcs:
	docker-compose exec api ./vendor/bin/phpcs --standard=ruleset.xml --extensions=php app routes config
phpcbf:
	docker-compose exec api ./vendor/bin/phpcbf --standard=ruleset.xml --extensions=php app routes config
all_test: phpcs unit_test
