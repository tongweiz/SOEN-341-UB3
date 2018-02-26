<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;
use App\User;

class ReplyTest extends BrowserKitTestCase
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
        ]);
    }


    /**
     * Test the case where a user is not authenticated
     * Stays on page.
     * Reply not added.
     */
    public function testReplyFailureNotAuthenticated()
    {
        $this->visit('/')
             ->press('Read')
             ->type('this is a reply', 'body')
             ->press('Submit')
             ->seePageIs('http://question/1')
             ->see('No comments');
    }

    /**
     * Test the case where a user is authenticated but wants to send an empty reply.
     * Stays on page.
     * Reply not added.
     */
    public function testReplyFailureEmptyBody()
    {
        $this->visit('/login')
            ->type('user2@gmail.com', 'email')
            ->type('secret1234', 'password')
            ->press('Login')
            ->isAuthenticated();

        $this->visit('/question/1')
            ->press('Submit')
            ->seePageIs('http://question/1')
            ->see('No comments');
    }

    /**
     * Test the case where a user is authenticated and creates a reply successfully.
     * Stays on page.
     * Reply is added to page and database.
     */
    public function testReplySuccessfullReply()
    {
        $this->visit('/login')
            ->type('user2@gmail.com', 'email')
            ->type('secret1234', 'password')
            ->press('Login')
            ->isAuthenticated();

        $this->visit('/question/1')
            ->type('this reply will be saved!', 'body')
            ->press('Submit')
            ->seePageIs('http://question/1')
            ->see('this reply will be saved!')
            ->dontSee('No comments');

        $this->seeInDatabase('replies', ['id' => 1,
            'content' => 'this reply will be saved!',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 0,
            'dislikectr' => 0,
            'status' => 0]);
    }
}
