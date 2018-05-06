<?php

use Phinx\Seed\AbstractSeed;

/**
 * Class UserSeed
 */
class RoleSeed extends AbstractSeed
{
    const NPC = '9afbcc51-26df-4d95-a6ce-ca791d3a5b5d';
    const PLAYER = 'e0298c29-20d7-4833-bc9c-70511311cfd7';
    const MANAGER = '0d032f51-69e9-4cb8-9d74-2a07f1aded0b';
    const ADMIN = 'ad3daea2-2d60-412e-a484-2d1e31bc7add';

    public function run()
    {
        $data = [
            [
                'uuid' => self::NPC,
                'name' => 'npc',
            ],
            [
                'uuid' => self::PLAYER,
                'name' => 'player',
            ],
            [
                'uuid' => self::MANAGER,
                'name' => 'manager',
            ],
            [
                'uuid' => self::ADMIN,
                'name' => 'admin',
            ],
        ];

        $posts = $this->table('role');
        $posts->insert($data)->save();
    }
}
