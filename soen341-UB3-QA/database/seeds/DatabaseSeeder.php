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
            'id' => 1,
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('user1'),
            'created_at' => '2018-02-10 12:00:00',
            'updated_at' => '2018-02-10 12:00:00'
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('user2'),
            'created_at' => '2018-02-10 13:00:00',
            'updated_at' => '2018-02-10 13:00:00'
        ]);

        DB::table('questions')->insert([
            'id' => 1,
            'title' => 'How come is the rainbow only 7 colors?',
            'content' => 'I dont understand why we always say that a rainbow is red, orange, yellow, green, blue, indigo, violet.
              When I look at a real rainbow I see a lot more colors.',
            'user_id' => '1',
            'created_at' => '2018-02-10 12:25:00',
            'updated_at' => '2018-02-10 12:25:00'
        ]);

        DB::table('questions')->insert([
            'id' => 2,
            'title' => 'Why do giraffes have such tall necks?',
            'content' => 'I dont know of any other animal with that characteristic. 
                I was wondering if it had maybe an evolutionary purpose?',
            'Label_1' => 'giraffes',
            'user_id' => '2',
            'created_at' => '2018-02-12 20:15:00',
            'updated_at' => '2018-02-12 20:15:00'
        ]);

        DB::table('questions')->insert([
            'id' => 3,
            'title' => 'Php database code in laravel wont run',
            'content' => 'I am doing a website in laravel and I dont understand how to access my tables in the controllers.
             My tables were done with the laravel class Schema if it helps.',
             'Label_2' => 'laravel',
            'user_id' => '1',
            'created_at' => '2018-02-10 08:26:00',
            'updated_at' => '2018-02-10 08:40:00'
        ]);

        DB::table('questions')->insert([
            'id' => 4,
            'title' => 'Should I eat pizza everyday if I want to lose weight?',
            'content' => 'I am trying to lose some weight but I have this bad habit of eating a lot of pizza. It
                is okay for me to continue eating it?',
            'Label_1' => 'pizza',
            'Label_2' => 'weight',
            'user_id' => '2',
            'created_at' => '2018-02-12 20:15:00',
            'updated_at' => '2018-02-12 20:15:00'
        ]);

        DB::table('replies')->insert([
            'id' => 1,
            'content' => 'There is actually more than 7 colors because they all blend into each other. 
                People say that because it is an easy way to remember the primary colors.',
            'question_id' => '1',
            'user_id' => '2',
            'likectr' => '25',
            'dislikectr' => '0',
            'status' => '1',
            'created_at' => '2018-01-29 15:12:00',
            'updated_at' => '2018-01-29 15:12:00'
        ]);

        DB::table('replies')->insert([
            'id' => 2,
            'content' => 'Because evolution.',
            'question_id' => '2',
            'user_id' => '1',
            'likectr' => '2',
            'dislikectr' => '10',
            'status' => '0',
            'created_at' => '2018-01-29 15:12:00',
            'updated_at' => '2018-01-29 15:12:00'
        ]);
    }
}
