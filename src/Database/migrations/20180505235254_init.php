<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    public function change()
    {

        $user = $this->table('user', ['id' => false, 'primary_key' => 'uuid']);
        $user->addColumn('uuid', 'uuid');
        $user->addColumn('email', 'string', ['limit' => 255]);
        $user->addColumn('name', 'string', ['limit' => 128]);
        $user->addColumn('password', 'string', ['limit' => 128]);
        $user->addColumn('title', 'string', ['limit' => 128]);
        $user->addColumn('loadedAt', 'integer', ['null' => true]);
        $user->addColumn('createdAt', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $user->addIndex(['email'], ['unique' => true, 'name' => 'idx_user_email']);
        $user->create();

        $roles = $this->table('role', ['id' => false, 'primary_key' => 'uuid']);
        $roles->addColumn('uuid', 'uuid');
        $roles->addColumn('name', 'string', ['limit' => 128]);
        $roles->addColumn('loadedAt', 'integer', ['null' => true]);
        $roles->addColumn('createdAt', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $roles->create();

        $userRoles = $this->table('user_role', ['id' => false, 'primary_key' => 'uuid']);
        $userRoles->addColumn('uuid', 'uuid');
        $userRoles->addColumn('userUuid', 'uuid');
        $userRoles->addColumn('roleUuid', 'uuid');
        $userRoles->addColumn('loadedAt', 'integer', ['null' => true]);
        $userRoles->addColumn('createdAt', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $userRoles->addIndex(['userUuid','roleUuid'], ['unique' => true, 'name' => 'idx_user_role']);
        $userRoles->create();

        $spaceship = $this->table('spaceship', ['id' => false, 'primary_key' => 'uuid']);
        $spaceship->addColumn('uuid', 'uuid');
        $spaceship->addColumn('userUuid', 'uuid');
        $spaceship->addColumn('title', 'string', ['limit' => 128]);
        $spaceship->addColumn('x', 'biginteger');
        $spaceship->addColumn('y', 'biginteger');
        $spaceship->addColumn('loadedAt', 'integer', ['null' => true]);
        $spaceship->addColumn('createdAt', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $spaceship->addForeignKey('userUuid', 'user', ['uuid']);
        $spaceship->create();
    }
}
