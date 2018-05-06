<?php


use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $user = $this->table('user', ['id' => false, 'primary_key' => 'uuid']);
        $user->addColumn('uuid', 'uuid');
        $user->addColumn('email', 'string', ['limit' => 255]);
        $user->addColumn('name', 'string', ['limit' => 128]);
        $user->addColumn('password', 'string', ['limit' => 128]);
        $user->addColumn('title', 'string', ['limit' => 128]);
        $user->addColumn('created', 'datetime');
        $user->addIndex(['email'], ['unique' => true, 'name' => 'idx_user_email']);
        $user->create();

        $spaceship = $this->table('spaceship', ['id' => false, 'primary_key' => 'uuid']);
        $spaceship->addColumn('uuid', 'uuid');
        $spaceship->addColumn('user_uuid', 'uuid');
        $spaceship->addColumn('title', 'string', ['limit' => 128]);
        $spaceship->addColumn('x', 'biginteger');
        $spaceship->addColumn('y', 'biginteger');
        $spaceship->addColumn('created', 'datetime');
        $spaceship->addForeignKey('user_uuid', 'user', ['uuid']);
        $spaceship->create();
    }
}
