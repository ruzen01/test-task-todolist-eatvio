.PHONY: copy-env install migrate serve start lint lint-fix

copy-env:
	@cp .env.example .env

install:
	@composer install
	@npm install
	@npm run build

migrate:
	@php artisan migrate

serve:
	@php artisan serve

start: copy-env install migrate serve

lint:
	@./vendor/bin/phpcs --standard=PSR12 app resources routes tests

lint-fix:
	@./vendor/bin/phpcbf --standard=PSR12 app resources routes tests