<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class Init
 */
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
        $user->addColumn('loadedAt', 'integer');
        $user->addColumn('createdAt', 'datetime');
        $user->addIndex(['email'], ['unique' => true, 'name' => 'idx_user_email']);
        $user->create();

        $roles = $this->table('role', ['id' => false, 'primary_key' => 'uuid']);
        $roles->addColumn('uuid', 'uuid');
        $roles->addColumn('name', 'string', ['limit' => 128]);
        $roles->addColumn('loadedAt', 'integer');
        $roles->addColumn('createdAt', 'datetime');
        $roles->create();

        $userRoles = $this->table('user_role', ['id' => false, 'primary_key' => 'uuid']);
        $userRoles->addColumn('uuid', 'uuid');
        $userRoles->addColumn('userUuid', 'uuid');
        $userRoles->addColumn('roleUuid', 'uuid');
        $userRoles->addColumn('loadedAt', 'integer');
        $userRoles->addColumn('createdAt', 'datetime');
        $userRoles->addIndex(['userUuid','roleUuid'], ['unique' => true, 'name' => 'idx_user_role']);
        $userRoles->create();

        $spaceship = $this->table('spaceship', ['id' => false, 'primary_key' => 'uuid']);
        $spaceship->addColumn('uuid', 'uuid');
        $spaceship->addColumn('userUuid', 'uuid');
        $spaceship->addColumn('title', 'string', ['limit' => 128]);
        $spaceship->addColumn('x', 'biginteger');
        $spaceship->addColumn('y', 'biginteger');
        $spaceship->addColumn('loadedAt', 'integer');
        $spaceship->addColumn('createdAt', 'datetime');
        $spaceship->addForeignKey('userUuid', 'user', ['uuid']);
        $spaceship->create();
    }
}
