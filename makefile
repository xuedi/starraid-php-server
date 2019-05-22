SQL_USER:=$(shell cat config/config.json | grep  'user' | tr -d ' ,\"' | cut -d: -f2)
SQL_PASS:=$(shell cat config/config.json | grep  'pass' | tr -d ' ,\"' | cut -d: -f2)
SQL_NAME:=$(shell cat config/config.json | grep  'name' | tr -d ' ,\"' | cut -d: -f2)
SQL_HOST:=$(shell cat config/config.json | grep  'host' | tr -d ' ,\"' | cut -d: -f2)
SQL_PORT:=$(shell cat config/config.json | grep  'port' | tr -d ' ,\"' | cut -d: -f2)
SQL:=mysql --user='$(SQL_USER)' --password='$(SQL_PASS)' --database='$(SQL_NAME)' --host='$(SQL_HOST)'

help: ## prints this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: reset_database ## does a composer install & reset of database
	composer install

update: ## updated composer packages
	composer update --no-suggest

suggest: ## show suggested composer packages and who is requesting them
	composer suggest -v

run: ## runs tha application
	php app.php

reset_database: ## resets the database to basic seed
	$(SQL) --execute='DROP TABLE IF EXISTS phinxlog, user_role, spaceship, user, role;'
	vendor/bin/phinx migrate -e default -c src/Database/phinx.php
	vendor/bin/phinx seed:run -e default -c src/Database/phinx.php

test: ## runs tests
	vendor/bin/phpstan analyse src/App --level 5
	./vendor/bin/phpunit --bootstrap vendor/autoload.php src/Tests/*

test_npc: ## test a dummy NPC (login & ping)
	php appNpc.php

clean: ## cleans up hard (vendor, cache ...)
	rm -rf vendor/


