lifetime?=1
dc_conf=-f docker-compose.yml --env-file .env
project_name=-p $(shell basename $(CURDIR))

.PHONY: default
default: help

help:
	@echo inicjacja projektu i uruchomienie: make init-project
	@echo wyłączenie: make down
	@echo włączenie: make up
.PHONY: init-project
init-project:
	cp env.txt .env
	docker compose $(dc_conf) $(project_name) up -d
	docker compose $(dc_conf) $(project_name) exec app composer require laravel/sanctum:*
	docker compose $(dc_conf) $(project_name) exec app composer install
	docker compose $(dc_conf) $(project_name) exec app npm install && npm --prefix app run build
	docker compose $(dc_conf) $(project_name) exec app php artisan migrate -q
	docker compose $(dc_conf) $(project_name) exec app php artisan install:api -q
	docker compose $(dc_conf) $(project_name) exec app chmod -R a+rw ./
	docker compose $(dc_conf) $(project_name) exec -T app composer run dev&
down:
	docker compose $(dc_conf) $(project_name) down
up:
	docker compose $(dc_conf) $(project_name) up -d
	docker compose $(dc_conf) $(project_name) exec -T app composer run dev&





