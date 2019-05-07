SQL_USER:=$(shell cat config/config.json | grep  'user' | tr -d ' ,\"' | cut -d: -f2)
SQL_PASS:=$(shell cat config/config.json | grep  'pass' | tr -d ' ,\"' | cut -d: -f2)
SQL_NAME:=$(shell cat config/config.json | grep  'name' | tr -d ' ,\"' | cut -d: -f2)
SQL_HOST:=$(shell cat config/config.json | grep  'host' | tr -d ' ,\"' | cut -d: -f2)
SQL_PORT:=$(shell cat config/config.json | grep  'port' | tr -d ' ,\"' | cut -d: -f2)
SQL:=mysql --user='$(SQL_USER)' --password='$(SQL_PASS)' --database='$(SQL_NAME)' --host='$(SQL_HOST)'

install: reset_database
	composer install

update:
	composer update

run:
	php app.php

reset_database:
	$(SQL) --execute='DROP TABLE IF EXISTS phinxlog, user_role, spaceship, user, role;'
	vendor/bin/phinx migrate -e default -c src/Database/phinx.php
	vendor/bin/phinx seed:run -e default -c src/Database/phinx.php

test_npc:
	php src/Tests/Stress/SimulateNpc.php

clean:
	rm -rf vendor/


