lifetime?=1
dc_conf=-f docker-compose.yml --env-file .env
project_name=-p $(shell basename $(CURDIR))

.PHONY: default
default: help

.PHONY: init-project
init-project: ## Initialize the project
	docker compose $(dc_conf) $(project_name) up -d
	docker compose $(dc_conf) $(project_name) exec app composer require laravel/sanctum:*
	docker compose $(dc_conf) $(project_name) exec app composer install
	docker compose $(dc_conf) $(project_name) exec app php artisan migrate -q
	docker compose $(dc_conf) $(project_name) exec app php artisan install:api -q
	docker compose $(dc_conf) $(project_name) exec app chmod -R a+rw ./






