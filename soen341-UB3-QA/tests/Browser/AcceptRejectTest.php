<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;
use App\Reply;
use Exception;

class AcceptRejectTest extends DuskTestCase
{
    //migrate db after every test
    use DatabaseMigrations;

    //set up environment for tests
    public function setUp()
    {
        parent::setUp();

        //create new users
        factory(User::class)->create([
            'id' => 1,
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'secret1234',
        ]);

        factory(Question::class)->create([
            'id' => 1,
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'labels' => 'Hello',
            'nb_replies' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        factory(User::class)->create([
            'id' => 2,
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'secret1234',
        ]);

        factory(Reply::class)->create([
            'id' => 1,
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 2,
            'status' => 1,
        ]);

        factory(Reply::class)->create([
            'id' => 2,
            'content' => 'second reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 6,
            'dislikectr' => 124,
            'status' => -1,
        ]);
    }

    /**
     * This test shows that when not authenticated, the icon to
     * accept a reply wont be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testAcceptIconGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertMissing('@accept-owner-1')
                ->assertMissing('@accept-owner-2')
                ->assertGuest();
        });
    }

    /**
     * This test shows that when not authenticated, the icon to normalize
     * a reply wont be there to click on.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testNormalizeIconGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertMissing('@normal-owner-1')
                ->assertMissing('@normal-owner-2')
                ->assertGuest();
        });
    }

    /**
     * This test shows that when not authenticated, the icon
     * to reject a reply wont be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRejectIconGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertMissing('@reject-owner-1')
                ->assertMissing('@reject-owner-2')
                ->assertGuest();
        });
    }

    /**
     * This test shows that when you are authenticated but NOT the owner
     * of the question, the icon to accept a reply wont be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testAcceptIconAuthenticatedNotOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertMissing('@accept-owner-1')
                ->assertMissing('@accept-owner-2');
        });
    }

    /**
     * This test shows that when you are authenticated but NOT the owner
     * of the question, the icon to normalize a reply wont be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testNormalizeIconAuthenticatedNotOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertMissing('@normal-owner-1')
                ->assertMissing('@normal-owner-2');
        });
    }

    /**
     * This test shows that when you are authenticated but NOT the owner
     * of the question, the icon to reject a reply wont be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRejectIconAuthenticatedNotOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertMissing('@reject-owner-1')
                ->assertMissing('@reject-owner-2');
        });
    }

    /**
     * This test shows that when you are authenticated AND the owner
     * of the question, you are able to accept a reply.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testAcceptReplyAuthenticatedOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')->dump();
               //->assertSee('Leave a Reply:')
               // ->assertVisible('@accept-owner-2')
                //->click('@accept-owner-2')
                //->pause(3000);
            //$this->assertDatabaseHas('replies', ['id' => 2, 'status' => 1]);
        });
    }

    /**
     * This test shows that when you are authenticated AND the owner
     * of the question, you are able to normalize a reply.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testNormalizeReplyAuthenticatedOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertVisible('@normal-owner-2')
                ->click('@normal-owner-2')
                ->pause(3000);
            $this->assertDatabaseHas('replies', ['id' => 2, 'status' => 0]);
        });
    }

    /**
     * This test shows that when you are authenticated AND the owner
     * of the question, you are able to reject a reply.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRejectReplyAuthenticatedOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertVisible('@reject-owner-1')
                ->click('@reject-owner-1')
                ->pause(3000);
            $this->assertDatabaseHas('replies', ['id' => 1, 'status' => -1]);
        });
    }

    /**
     * This test shows that when you are authenticated AND the owner
     * of the question, if you click on an the icon to accept twice
     * nothing special will happen.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testClickAcceptTwiceOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->click('@accept-owner-2')
                ->pause(3000);
            $this->assertDatabaseHas('replies', ['id' => 2, 'status' => 1]);

            $browser->click('@accept-owner-2')->pause(3000);
            $this->assertDatabaseHas('replies', ['id' => 2, 'status' => 1]);
        });
    }

    /**
     * This test shows that when you are NOT authenticated an icon near an
     * accepted reply will be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testAcceptResultGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->logout()
                ->visit('/question/1')
                ->assertVisible('@accept-user-1')
                ->assertGuest();
        });
    }

    /**
     * This test shows that when you are NOT authenticated an icon near a
     * rejected reply will be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function tesRejectResultGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertVisible('@reject-user-2')
                ->assertGuest();
        });
    }

    /**
     * This test shows that when you are authenticated but are NOT
     * the owner of the question, an icon near an
     * accepted reply will be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testAcceptResultAuthenticatedNotOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertVisible('@accept-user-1')
                ->assertAuthenticated();
        });
    }

    /**
     * This test shows that when you are authenticated but are NOT
     * the owner of the question, an icon near a
     * rejected reply will be there.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRejectResultAuthenticatedNotOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertVisible('@reject-user-2')
                ->assertAuthenticated();
        });
    }

    /**
     * This test shows that when you are authenticated but are NOT
     * the owner of the question, clicking on the icon near an
     * accepted reply will do nothing.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testAcceptResultAuthenticatedClick()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertVisible('@accept-user-1')
                ->click('@accept-user-1')
                ->assertAuthenticated();
            $this->assertDatabaseHas('replies', ['id' => 1, 'status' => 1]);
        });
    }

    /**
     * This test shows that when you are authenticated but are NOT
     * the owner of the question, clicking on the icon near a
     * rejected reply will do nothing.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRejectResultAuthenticatedClick()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertVisible('@reject-user-2')
                ->click('@reject-user-2')
                ->assertAuthenticated();
            $this->assertDatabaseHas('replies', ['id' => 2, 'status' => -1]);
        });
    }
}
