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
