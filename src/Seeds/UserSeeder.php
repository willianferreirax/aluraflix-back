<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'name'    => 'foo',
                'login'   => 'test',
                'pass'    => '$2y$10$7hAdgg1dZsQz1wogPgevuuxeQhoZJSNdhIj/Gn9Apyh3EwqavcVQu',

                'created' => date('Y-m-d H:i:s'),
            ]
        ];

        $users = $this->table('users');
        $users->truncate();
        $users->insert($data)
              ->saveData();
    }
}
