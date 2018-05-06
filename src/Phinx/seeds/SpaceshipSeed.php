<?php


use Phinx\Seed\AbstractSeed;

class SpaceshipSeed extends AbstractSeed
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
                'uuid' => '14895e5c-b14a-40dd-857b-a25beeafccea',
                'user_uuid' => 'a0f52f45-6aab-449f-b952-08fff7542f19',
                'title' => 'SpaceShip1',
                'x' => '100',
                'y' => '200',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => 'ad59ffc3-f00e-4f37-9d9c-29ef58f4c853',
                'user_uuid' => 'ce030fe6-20bd-47e2-965a-a5f518aebc00',
                'title' => 'Pirate1',
                'x' => '-100',
                'y' => '100',
                'created' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => 'aacfc8ce-f8ec-4f90-a789-90d5b223c6d9',
                'user_uuid' => 'ce030fe6-20bd-47e2-965a-a5f518aebc00',
                'title' => 'Pirate2',
                'x' => '-200',
                'y' => '-200',
                'created' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table('spaceship');
        $posts->insert($data)->save();
    }
}
