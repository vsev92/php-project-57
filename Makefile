start:
	php artisan serve
install:
	composer install
validate:
	composer validate
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app tests
stan:
	composer phpstan
test:
	php artisan test 
