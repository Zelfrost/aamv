SHELL = /bin/bash
.DEFAULT_GOAL := help

PROJECT = aamv
NETWORK = $(PROJECT)_default
COMPOSE = docker compose

.PHONY: start
start: up install ## Starts the application

.PHONY: up
up: ## Launches containers
	@$(COMPOSE) up --remove-orphans -d

.PHONY: install
install: ## Launches composer install
	@$(COMPOSE) exec --user www-data php sh -c "composer install"


.PHONY: update
update: ## Launches composer update. repo=xxx to update a specific repo
	$(eval repo ?= )
	@$(COMPOSE) exec --user www-data php sh -c "composer update $(repo)"

.PHONY: create-db
create-db: ## Creates the database
	@$(COMPOSE) exec --user www-data php sh -c "bin/console doctrine:database:create"

.PHONY: drop-db
drop-db: ## Dropes the database
	@$(COMPOSE) exec --user www-data php sh -c "bin/console doctrine:database:drop --force --if-exists"

.PHONY: install-db
install-db: ## Creates the database schema and load fixtures
	@$(COMPOSE) exec --user www-data php sh -c "bin/console doctrine:schema:create"
	@$(COMPOSE) exec --user www-data php sh -c "bin/console doctrine:fixtures:load --append"

.PHONY: update-db
update-db: ## Updates the database schema
	@$(COMPOSE) exec --user www-data php sh -c "bin/console doctrine:schema:update --force"

.PHONY: reload-db
reload-db: drop-db create-db install-db ## Dropes, re-create and load the database schema and fixtures

.PHONY: exec
exec: ## Executes a command in a container
	$(eval app ?= php)
	$(eval user ?= www-data)
	$(eval cmd ?= bash)
	@$(COMPOSE) exec --user $(user) $(app) sh -c "$(cmd)"

.PHONY: load
load: ## Loads SQL dumps from docker/dump/*.sql into the database
	@for file in docker/dump/*.sql; do \
		if [ -f "$$file" ]; then \
			echo "Loading $$file..."; \
			$(COMPOSE) exec -T mysql mysql aamv -hmysql -uroot -proot < "$$file"; \
		fi; \
	done

.PHONY: mysql
mysql: ## Connects you to the mysql server
	@$(COMPOSE) run --rm mysql mysql aamv -hmysql -uroot -proot

.PHONY: ps
ps: ## Shows containers state
	@$(COMPOSE) ps

.PHONY: logs
logs: ## Shows containers logs
	$(eval app ?= mysql php nginx)
	@$(COMPOSE) logs -f $(app)

.PHONY: stop
stop: ## Stops a container
	$(eval app ?= mysql php nginx)
	@$(COMPOSE) stop $(app) 2>&1

.PHONY: down
down: ## Shutdowns a container
	@$(COMPOSE) down -v --remove-orphans

.PHONY: rm
rm: ## Removes a container
	$(eval app ?= mysql php nginx)
	@$(COMPOSE) rm --all -f $(app) 2>&1

.PHONY: destroy
destroy: stop rm ## Destroys a container

.PHONY: recreate
recreate: destroy up ## Recreates a container

.PHONY: help
help: ## Show help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
