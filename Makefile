.PHONY: test install upgrade dumpautoload

test:
	docker run --rm -v $(PWD):/var/www -w /var/www php:7.2 vendor/bin/phpunit --bootstrap vendor/autoload.php tests

install:
	docker run --rm -v $(PWD):/var/www -w /var/www composer composer install

upgrade:
	docker run --rm -v $(PWD):/var/www -w /var/www composer composer upgrade

dumpautoload:
	docker run --rm -v $(PWD):/var/www -w /var/www composer composer dumpautoload
