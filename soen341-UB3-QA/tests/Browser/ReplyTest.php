<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;
use Laravel\Dusk\Browser;
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

        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'nb_replies' => 1,
        ]);

        factory(User::class)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'secret1234',
        ]);
    }

    /**
     * Test the case where a user is not authenticated
     * Stays on page.
     * Reply not added.
     */
    public function testReplyFailureNotAuthenticated()
    {
        $this->dontSeeIsAuthenticated();

        $this->visit('/question/1')
             ->type('this is a reply', 'body')
             ->press('Submit')
             ->seePageIs('http://localhost/question/1')
             ->see('No comments')
             ->dontSeeInDatabase('replies', [
                    'content' => 'this is a reply']);
    }

    /**
     * Test the case where a user is authenticated but wants to send an empty reply.
     * Stays on page.
     * Reply not added.
     */
    public function testReplyFailureEmptyBody()
    {
        //login as user id 2
        $user = \App\User::find(2);

        $this->actingAs($user)
            ->visit('/question/1')
            ->press('Submit')
            ->seePageIs('http://localhost/question/1')
            ->see('No comments')
            ->dontSeeInDatabase('replies', [
                'content' => ''])
            ->isAuthenticated();
    }

    /**
     * Test the case where a user is authenticated and creates a reply successfully.
     * Stays on page.
     * Reply is added to page and database.
     */
    public function testReplySuccessfullReply()
    {
        //login as user id 2
        $user = \App\User::find(2);

        $this->actingAs($user)
            ->visit('/question/1')
            ->type('saved', 'body')
            ->press('Submit')
            ->seePageIs('http://localhost/question/1')
            ->see('saved')
            ->dontSee('No comments')
            ->isAuthenticated();

       $this->seeInDatabase('replies', ['id' => 1,
            'content' => 'saved',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 0,
            'dislikectr' => 0,
            'status' => 0]);
    }
}
