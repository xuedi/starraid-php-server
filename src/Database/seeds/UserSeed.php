<?php

use Phinx\Seed\AbstractSeed;

class UserSeed extends AbstractSeed
{
    const XUEDI = 'a0f52f45-6aab-449f-b952-08fff7542f19';
    const NPC = 'ce030fe6-20bd-47e2-965a-a5f518aebc00';
    const PLAYER1 = '3898c34a-200b-48e5-9cc5-c1143a9807ae';
    const PLAYER2 = '657d7eaf-5d0a-44b4-bbd1-412ee3d22b61';

    public function run()
    {
        $data = [
            [
                'uuid' => self::XUEDI,
                'email' => 'xuedi@beijingcode.org',
                'name' => 'xuedi',
                'password' => '12345',
                'title' => '雪地',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => self::NPC,
                'email' => 'npc@beijingcode.org',
                'name' => 'npc',
                'password' => '12345',
                'title' => 'NPC',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => self::PLAYER1,
                'email' => 'player1@beijingcode.org',
                'name' => 'player1',
                'password' => '12345',
                'title' => 'Player 1',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => self::PLAYER2,
                'email' => 'player2@beijingcode.org',
                'name' => 'player2',
                'password' => '12345',
                'title' => 'Player 2',
                'loadedAt' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table('user');
        $posts->insert($data)->save();
    }
}
