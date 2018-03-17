<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;

class ReplyTest extends DuskTestCase
{
    //will rollback db after every test
    //When run LOCALLY: have the db and tables setup but no data.
    use DatabaseMigrations;

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
     * @throws
     */
   /* public function testReplyFailureNotAuthenticated()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->dump()
                ->type('body', 'this is a reply')
                ->press('Submit')
                ->assertPathIs('/question/1')
                ->assertSee('No comments')
                ->assertDatabaseMissing('replies', [
                    'content' => 'this is a reply']);
        });
    }*/

    /**
     * Test the case where a user is authenticated but wants to send an empty reply.
     * Stays on page.
     * Reply not added.
     * @throws
     */
    /*public function testReplyFailureEmptyBody()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->press('Submit')
                ->assertPathIs('/question/1')
                ->assertSee('No comments')
                ->assertAuthenticated()
                ->assertDatabaseMissing('replies', [
                    'content' => '']);
        });
    }*/

    /**
     * Test the case where a user is authenticated and creates a reply successfully.
     * Stays on page.
     * Reply is added to page and database.
     * @throws
     */
    /*public function testReplySuccessfullReply()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->type('body', 'this reply will be saved')
                ->press('Submit')
                ->assertPathIs('/question/1')
                ->assertSee('this reply will be saved')
                ->assertAuthenticated()
                ->assertDatabaseHas('replies', [
                    'id' => 1,
                    'content' => 'saved',
                    'question_id' => 1,
                    'user_id' => 2,
                    'likectr' => 0,
                    'dislikectr' => 0,
                    'status' => 0]);
        });
    }*/
}
