<?php

namespace Tests\Browser;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;
use App\User;

class QuestionAndReplyListingsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    //set up environment for tests
    public function setUp()
    {
        parent::setUp();

        //create new users
        factory(User::class)->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'secret1234',
        ]);

        factory(User::class)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'secret1234',
        ]);

        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'labels' => 'test1',
            'created_at' => '2018-03-17 12:20:00',
            'updated_at' => '2018-03-17 12:20:00',
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1,
            'labels' => 'test2,test3',
            'created_at' => '2018-03-17 12:20:00',
            'updated_at' => '2018-03-17 12:20:00',
            'nb_replies' => 0,
        ]);
    }

    /**
     * This test shows that no questions will be showed on the home page
     * if the database is empty.
     */
    public function testListingNoQuestions()
    {
        //empty database of questions
        Question::find(1)->delete();
        Question::find(2)->delete();

        //no question is being showed because database is empty
        $this->visit('/home')
            ->see('No questions were asked yet!');
    }

    /**
     * This test shows that all questions in the database will be showed on the home
     * page listing as a guest. Question information are shown.
     */
    public function testListingAllQuestionsAsGuest()
    {
        $this->visit('/home')
            ->see('first title test')
            ->see('first content')
            ->see('user1')
            ->see('test1')
            ->see('0 replies')
            ->see('17th of March of 2018')
            ->see('12:20:00')
            ->see('second title test')
            ->see('second content')
            ->see('user1')
            ->see('test2')
            ->see('test3')
            ->see('0 replies')
            ->see('17th of March of 2018')
            ->see('12:20:00');
    }

    /**
     * This test shows that all questions in the database will be showed on the home
     * page listing as an authenticated user. Question info are shown.
     */
    public function testListingAllQuestionsAsUser()
    {
        $user = \App\User::find(1);

        $this->actingAs($user)->visit('/home')
            ->see('first title test')
            ->see('first content')
            ->see('user1')
            ->see('test1')
            ->see('0 replies')
            ->see('17th of March of 2018')
            ->see('12:20:00')
            ->see('second title test')
            ->see('second content')
            ->see('user1')
            ->see('test2')
            ->see('test3')
            ->see('0 replies')
            ->see('17th of March of 2018')
            ->see('12:20:00')
            ->isAuthenticated();
    }

    /**
     * Tests whether all the necessary specific question information is displayed as a guest.
     * Question has no replies.
     */
    public function testDisplayQuestionInfoWithoutRepliesAsAGuest()
    {
        $this->visit('/question/1')
            ->see('first title test')
            ->see('user1')
            ->see('test1')
            ->see('17th of March of 2018')
            ->see('12:20:00')
            ->see('first content')
            ->see('No comments');
    }

    /**
     * Tests whether all the necessary question information is displayed.
     * Question has replies.
     */
    public function testDisplayQuestionInfoWithRepliesAsAGuest()
    {
        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'created_at' => '2018-03-27 15:00:00',
            'status' => 0,
        ]);

        $this->visit('/question/1')
            ->see('first title test')
            ->see('user1')
            ->see('test1')
            ->see('17th of March of 2018')
            ->see('12:20:00')
            ->see('first content')
            ->see('1 answer(s)')
            ->see('first reply')
            ->see(66)
            ->see(124)
            ->see('27th of March of 2018')
            ->see('15:00:00');
    }

    /**
     * Tests whether all the necessary question information is displayed as
     * an authenticated user.
     * Question has a reply.
     */
    public function testDisplayQuestionInfoAsAUserMultipleReplies()
    {
        $user = \App\User::find(2);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'created_at' => '2018-03-27 15:00:00',
            'status' => 0,
        ]);
        factory(Reply::class)->create([
            'content' => 'second reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 5,
            'dislikectr' => 4,
            'created_at' => '2018-03-27 15:00:00',
            'status' => 0,
        ]);

        $this->actingAs($user)
            ->visit('/question/1')
            ->see('first title test')
            ->see('user1')
            ->see('test1')
            ->see('17th of March of 2018')
            ->see('12:20:00')
            ->see('first content')
            ->see('2 answer(s)')
            ->see('first reply')
            ->see(66)
            ->see(124)
            ->see('27th of March of 2018')
            ->see('15:00:00')
            ->see('second reply')
            ->see(5)
            ->see(4)
            ->see('27th of March of 2018')
            ->see('15:00:00');
    }
}
