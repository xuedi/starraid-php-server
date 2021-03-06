<?php

use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;

class UserRoleSeed extends AbstractSeed
{

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'RoleSeed',
            'UserSeed',
        ];
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $data = [
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::XUEDI,
                'roleUuid' => RoleSeed::ADMIN,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::XUEDI,
                'roleUuid' => RoleSeed::PLAYER,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::NPC,
                'roleUuid' => RoleSeed::NPC,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::PLAYER1,
                'roleUuid' => RoleSeed::PLAYER,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'userUuid' => UserSeed::PLAYER2,
                'roleUuid' => RoleSeed::PLAYER,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table('user_role');
        $posts->insert($data)->save();
    }
}
