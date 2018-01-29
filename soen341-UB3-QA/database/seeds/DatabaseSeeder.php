<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //php artisan db:seed
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('user1'),
        ]);

        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('user2'),
        ]);

        DB::table('questions')->insert([
            'title' => 'Slightly important Color question',
            'content' => 'I am intrigued by why the sky is blue?',
            'user_id' => '1',
        ]);

        DB::table('questions')->insert([
            'title' => 'Very important Animal question',
            'content' => 'Why are giraffes so tall?',
            'user_id' => '2',
        ]);

        DB::table('replies')->insert([
            'content' => 'Because light reflects on the ocean.',
            'question_id' => '1',
            'user_id' => '2',
            'likectr' => '25',
            'dislikectr' => '0',
            'status' => '1',
        ]);

        DB::table('replies')->insert([
            'content' => 'Because evolution.',
            'question_id' => '2',
            'user_id' => '1',
            'likectr' => '2',
            'dislikectr' => '10',
            'status' => '0',
        ]);
    }
}
