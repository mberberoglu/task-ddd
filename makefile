.PHONY: start
start: erase build up db ## clean current environment, recreate dependencies and spin up again

.PHONY: stop
stop: ## stop environment
		docker-compose -f docker/docker-compose.yml stop

.PHONY: rebuild
rebuild: start ## same as start

.PHONY: erase
erase: ## stop and delete containers, clean volumes.
		docker-compose -f docker/docker-compose.yml stop
		docker-compose -f docker/docker-compose.yml rm -v -f

.PHONY: build
build: ## build environment and initialize composer and project dependencies
		docker-compose -f docker/docker-compose.yml build
		docker-compose -f docker/docker-compose.yml run --rm php sh -lc 'composer install'

.PHONY: composer-update
composer-update: ## Update project dependencies
		docker-compose -f docker/docker-compose.yml run --rm php sh -lc 'composer update'

.PHONY: up
up: ## spin up environment
		docker-compose -f docker/docker-compose.yml up -d

.PHONY: style
style: ## executes php analizers
		docker-compose -f docker/docker-compose.yml run --rm php sh -lc './vendor/bin/phpstan analyse -l 6 -c phpstan.neon src tests'

.PHONY: cs
cs: ## executes php cs fixer
		docker-compose -f docker/docker-compose.yml run --rm php sh -lc './vendor/bin/php-cs-fixer --no-interaction --diff -v fix'

.PHONY: cs-check
cs-check: ## executes php cs fixer in dry run mode
		docker-compose -f docker/docker-compose.yml run --rm php sh -lc './vendor/bin/php-cs-fixer --no-interaction --dry-run --diff -v fix'

.PHONY: layer
layer: ## Check issues with layers
		docker-compose -f docker/docker-compose.yml run --rm php sh -lc 'php bin/deptrac.phar analyze --formatter-graphviz=0'

.PHONY: db
db: ## recreate database
		docker-compose -f docker/docker-compose.yml exec php sh -lc './bin/console d:d:d --if-exists --force'
		docker-compose -f docker/docker-compose.yml exec php sh -lc './bin/console d:d:c'
		docker-compose -f docker/docker-compose.yml exec php sh -lc './bin/console d:s:u --force'
		docker-compose -f docker/docker-compose.yml exec php sh -lc './bin/console app:init-data'

.PHONY: schema-validate
schema-validate: ## validate database schema
		docker-compose -f docker/docker-compose.yml exec php sh -lc './bin/console d:s:v'

.PHONY: xon
xon: ## activate xdebug simlink
		docker-compose -f docker/docker-compose.yml exec php sh -lc 'xon'

.PHONY: xoff
xoff: ## deactivate xdebug
		docker-compose -f docker/docker-compose.yml exec php sh -lc 'xoff'

.PHONY: sh
sh: ## gets inside a container, use 's' variable to select a service. make s=php sh
		docker-compose -f docker/docker-compose.yml exec $(s) sh -l

.PHONY: help
help: ## Display this help message
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
