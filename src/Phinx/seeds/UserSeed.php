<?php


use Phinx\Seed\AbstractSeed;

class UserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'uuid' => 'a0f52f45-6aab-449f-b952-08fff7542f19',
                'email' => 'xuedi@beijingcode.org',
                'name' => 'xuedi',
                'password' => '12345',
                'title' => '雪地',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => 'ce030fe6-20bd-47e2-965a-a5f518aebc00',
                'email' => 'npc@beijingcode.org',
                'name' => 'npc',
                'password' => '12345',
                'title' => 'NPC',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => '3898c34a-200b-48e5-9cc5-c1143a9807ae',
                'email' => 'player1@beijingcode.org',
                'name' => 'player1',
                'password' => '12345',
                'title' => 'Player 1',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => '657d7eaf-5d0a-44b4-bbd1-412ee3d22b61',
                'email' => 'player2@beijingcode.org',
                'name' => 'player2',
                'password' => '12345',
                'title' => 'Player 2',
                'created' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table('user');
        $posts->insert($data)->save();
    }
}
