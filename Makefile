THIS := $(realpath $(lastword $(MAKEFILE_LIST)))
HERE := $(shell dirname $(THIS))


.PHONY: all

all: bannar setup install migrate note serve

setup:
	@php -r "file_exists('.env') || copy('.env.example', '.env');"
	@rm -fr database/database.sqlite
	@touch database/database.sqlite

install:
	@$(MAKE) composer
	@$(MAKE) npm
	@$(MAKE) key

composer:
	@composer install

npm:
	@npm ci
	@npm run dev

key:
	@php artisan key:generate

migrate:
	@php artisan migrate:refresh
	@php artisan db:seed

serve:
	@php artisan serve
	@$(MAKE) note

test:
	@php ./vendor/bin/phpunit --testdox

test-coverage:
	@php ./vendor/bin/phpunit --coverage-html storage/logs/coverage --testdox

note:
	@echo "\n======================================== [NOTE] ========================================"
	@echo "You're ready to go! Visit Ping CRM in your browser, and login with:					 "
	@echo "[*] Username: johndoe@example.com														 "
	@echo "[*] Password: secret"
	@echo "========================================================================================\n"

bannar:
	@echo " _____ _              _____ _____  __  __"
	@echo "|  __ (_)            / ____|  __ \|  \/  |"
	@echo "| |__) | _ __   __ _| |    | |__) | \  / |"
	@echo "|  ___/ | '_ \ / _\` | |    |  _  /| |\/| |"
	@echo "| |   | | | | | (_| | |____| | \ \| |  | |"
	@echo "|_|   |_|_| |_|\__, |\_____|_|  \_\_|  |_|"
	@echo "                __/ |"
	@echo "               |___/"
	@echo "\n"
