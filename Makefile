.PHONY: build up down ps logs migrate seed test lint install_composer serve

build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

ps:
	docker compose ps

logs:
	docker compose logs -f

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

composer-install:
	composer install

lint:
	./vendor/bin/phpcs --standard=PSR12 app

lint-fix:
	./vendor/bin/phpcbf --standard=PSR12 app

serve:
	docker compose exec app php artisan serve --host=0.0.0.0 --port=8000

init: composer-install build up migrate seed serve