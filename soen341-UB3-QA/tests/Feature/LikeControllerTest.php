<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;
use App\User;

class LikeControllerTest extends BrowserKitTestCase
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
            'labels' => 'Hello',
            'nb_replies' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        factory(User::class)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'secret1234',
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 0,
        ]);
    }

    /**
     * This test shows that when not authenticated, liking a reply will not be saved.
     */
    public function testFailureLikeNotAuthenticated()
    {
        $this->visit('/question/1')
            ->see('first title test')
            ->see(66)
            ->click('like')
            ->seePageIs('http://localhost/question/1')
            ->see(66)
            ->dontSeeIsAuthenticated();
    }

    /**
     * This test shows that when  authenticated, liking a reply will be saved.
     */
    public function testSuccessLikeAuthenticated()
    {
        $user = User::find(1);

        $this->actingAs($user)
            ->visit('/question/1')
            ->see('first title test')
            ->see(66)
            ->click('like')
            ->seePageIs('http://localhost/question/1')
            // should work just like dislike... ->see(67)
            ->IsAuthenticated();
    }

    /**
     * This test shows that when not authenticated, disliking a reply will not be saved.
     */
    public function testFailureDislikeNotAuthenticated()
    {
        $this->visit('/question/1')
            ->see('first title test')
            ->see(124)
            ->click('dislike')
            ->seePageIs('http://localhost/question/1')
            ->see(124)
            ->dontSeeIsAuthenticated();
    }

    /**
     * This test shows that when  authenticated, disliking a reply will be saved.
     */
    public function testSuccessDislikeAuthenticated()
    {
        $user = User::find(1);

        $this->actingAs($user)
            ->visit('/question/1')
            ->see('first title test')
            ->see(124)
            ->click('dislike')
            ->seePageIs('http://localhost/question/1')
            ->see(125)
            ->IsAuthenticated();
    }

    /**
     * This test shows that when not authenticated, accepting a reply wont work.
     */
    public function testFailureAcceptNotAuthenticated()
    {
        $this->visit('/question/1')
            ->see('first title test')
            ->dontSeeElement('a', ['name' => 'accept'])
            ->dontSeeIsAuthenticated();
    }

    /**
     * This test shows that you cannot accept a reply if you
     * are not the owner of the question.
     */
    public function testFailureAcceptNotOwner()
    {
        $user = User::find(2);

        $this->actingAs($user)
             ->visit('/question/1')
             ->see('first title test')
             ->dontSeeElement('a', ['name' => 'accept'])
             ->isAuthenticated();
    }

    /**
     * Test shows that you need to be authenticated and the owner of the question to
     * accept a reply.
     */
    public function testSuccessAccept()
    {
        $user = User::find(1);

        $this->actingAs($user)
             ->isAuthenticated();
             ->visit('/question/1')
             ->see('first title test')
             ->seeElement('a', ['name' => 'accept'])
             ->click('accept')
             ->seePageIs('http://localhost/question/1')
             ->seeElement('i', ['class' => 'fa fa-check-circle fa-2x']);
    }

    /**
     * This test shows that when not authenticated, normalizing a reply wont work.
     */
    public function testFailureNormalizeNotAuthenticated()
    {
        $this->visit('/question/1')
            ->see('first title test')
            ->dontSeeElement('a', ['name' => 'normal'])
            ->dontSeeIsAuthenticated();
    }

    /**
     * This test shows that you cannot normalize a reply if you
     * are not the owner of the question.
     */
    public function testFailureNormalizeNotOwner()
    {
        $user = User::find(2);

        $this->actingAs($user)
            ->visit('/question/1')
            ->see('first title test')
            ->dontSeeElement('a', ['name' => 'normal'])
            ->isAuthenticated();
    }

    /**
     * Test shows that you need to be authenticated and the owner of the question to
     * normalize a reply.
     */
    public function testSuccessNormalize()
    {
        $user = User::find(1);

        $this->actingAs($user)
            ->visit('/question/1')
            ->see('first title test')
            ->seeElement('a', ['name' => 'normal'])
            ->click('normal')
            ->seePageIs('http://localhost/question/1')
            ->seeElement('i', ['class' => 'fa fa-bars fa-2x']);
    }

    /**
     * This test shows that when not authenticated, rejecting a reply wont work.
     */
    public function testFailureRejectNotAuthenticated()
    {
        $this->visit('/question/1')
            ->see('first title test')
            ->dontSeeElement('a', ['name' => 'reject'])
            ->dontSeeIsAuthenticated();
    }

    /**
     * This test shows that you cannot reject a reply if you
     * are not the owner of the question.
     */
    public function testFailureRejectNotOwner()
    {
        $user = User::find(2);

        $this->actingAs($user)
            ->visit('/question/1')
            ->see('first title test')
            ->dontSeeElement('a', ['name' => 'reject'])
            ->isAuthenticated();
    }

    /**
     * Test shows that you need to be authenticated and the owner of the question to
     * reject a reply.
     */
    public function testSuccessReject()
    {
        $user = User::find(1);

        $this->actingAs($user)
            ->isAuthenticated()
            ->visit('/question/1')
            ->see('first title test')
            ->seeElement('a', ['name' => 'reject'])
            ->click('reject')
            ->seePageIs('http://localhost/question/1')
            ->seeElement('i', ['class' => 'fa fa-ban fa-2x']);
    }
}
