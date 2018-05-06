<?php

use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;

/**
 * Class UserSeed
 */
class UserRoleSeed extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::XUEDI,
                'roleUuid' => RoleSeed::ADMIN,
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::XUEDI,
                'roleUuid' => RoleSeed::PLAYER,
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::NPC,
                'roleUuid' => RoleSeed::NPC,
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::PLAYER1,
                'roleUuid' => RoleSeed::PLAYER,
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::PLAYER2,
                'roleUuid' => RoleSeed::PLAYER,
            ],
        ];

        $posts = $this->table('user_role');
        $posts->insert($data)->save();
    }
}
