SQL_USER:=$(shell cat config/config.json | grep  'user' | tr -d ' ,\"' | cut -d: -f2)
SQL_PASS:=$(shell cat config/config.json | grep  'pass' | tr -d ' ,\"' | cut -d: -f2)
SQL_NAME:=$(shell cat config/config.json | grep  'name' | tr -d ' ,\"' | cut -d: -f2)

install:
	composer self-update
	composer install
	php src/Database/createPhinxConfig.php

update:
	composer self-update
	composer update

run:
	php app.php

reset:
	mysql --user='$(SQL_USER)' --password='$(SQL_PASS)' --database='$(SQL_NAME)' --execute='DROP TABLE user_role, spaceship, user, role;'
	mysql --user='$(SQL_USER)' --password='$(SQL_PASS)' --database='$(SQL_NAME)' --execute='DELETE FROM phinxlog;'
	vendor/bin/phinx migrate -e default -c src/Database/phinx.php
	vendor/bin/phinx seed:run -e default -c src/Database/phinx.php

clean:
	rm -rf vendor/


