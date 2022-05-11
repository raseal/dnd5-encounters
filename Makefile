all: help
.PHONY: help status build composer-install build-container start stop down destroy shell test hooks run-tests

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

help: Makefile
	@sed -n 's/^##//p' $<

## status:	Show containers status
status:
	@docker-compose ps

## build:		Start container, install packages and prepare databases
build: build-container start hooks composer-install load-mongo load-mysql-schema

## build-container:Rebuild a container
build-container:
	@docker-compose up --build --force-recreate --no-deps -d

## start:		Start container
start:
	@docker-compose up -d

## stop:		Stop containers
stop:
	@docker-compose stop

## down:		Stop containers and remove stopped containers and any network created
down:
	@docker-compose down

## destroy:	Stop containers and remove its volumes (all information inside volumes will be lost)
destroy:
	@docker-compose down -v

## shell:		Interactive shell inside docker
shell:
	@docker-compose exec php_container sh

## install:	Install packages
composer-install:
	@docker-compose exec php_container composer install

## test:		Run all tests inside docker
test:
	@docker-compose exec php_container make run-tests

## analyse:	Executes phpstan
analyse:
	@docker-compose exec php_container ./vendor/bin/phpstan analyse

## run-tests:	Run all tests
run-tests:
	XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-text --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml tests

load-mongo:
	@docker-compose exec php_container apps/EncounterAPI/bin/console dataloader:load

load-mysql-schema:
	@docker-compose exec php_container apps/EncounterAPI/bin/console doctrine:migrations:migrate --no-interaction

hooks:
	rm -rf .git/hooks
	ln -s ../docs/git/hooks-docker .git/hooks
