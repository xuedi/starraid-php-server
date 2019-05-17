<?php

use Phinx\Seed\AbstractSeed;

class ObjectSeed extends AbstractSeed
{

    public function getDependencies()
    {
        return [
            'UserSeed',
        ];
    }

    public function run()
    {
        $data = [
            [
                'uuid' => '14895e5c-b14a-40dd-857b-a25beeafccea',
                'userUuid' => UserSeed::XUEDI,
                'title' => 'SpaceShip1',
                'x' => '100',
                'y' => '200',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => 'ad59ffc3-f00e-4f37-9d9c-29ef58f4c853',
                'userUuid' => UserSeed::NPC,
                'title' => 'Pirate1',
                'x' => '-100',
                'y' => '100',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => 'aacfc8ce-f8ec-4f90-a789-90d5b223c6d9',
                'userUuid' => UserSeed::NPC,
                'title' => 'Pirate2',
                'x' => '-200',
                'y' => '-200',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table('spaceship');
        $posts->insert($data)->save();
    }
}
