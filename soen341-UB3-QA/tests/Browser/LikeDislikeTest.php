<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;
use App\Reply;
use Exception;


class LikeDislikeTest extends DuskTestCase
{
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
            'dislikectr' => 124,
            'status' => 0,
        ]);
    }

    /**
     * This test shows as a guest, liking a reply will not be saved.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testLikeGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertGuest();
            $this->assertDatabaseHas('replies', ['likectr' => 66]);
        });
    }

    /**
     * This test shows as a guest, disliking a reply will not be saved.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDislikeGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertGuest();
            $this->assertDatabaseHas('replies', ['dislikectr' => 124]);
        });
    }

    /**
     * This test shows that when authenticated, liking a reply will be saved.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
   /* public function testLikeUser()
    {
        $this->browse(function (Browser $browser){
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',67);
            $this->assertDatabaseHas('replies', ['likectr' => 67]);
        });
    }*/

    /**
     * This test shows that when authenticated, disliking a reply will be saved.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    /*public function testDislikeUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',125);
            $this->assertDatabaseHas('replies', ['dislikectr' => 125]);
        });
    }*/

    /**
     * This test shows that when authenticated, if you change opinion
     * after liking or disliking a reply, you can switch your choice.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    /*public function testSwitchOpinionUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',125)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',67)
                ->assertSeeIn('@numdislike-1',124);
            $this->assertDatabaseHas('replies', ['likectr' => 67, 'dislikectr' => 124]);
        });
    }*/

    /**
     * This test shows that when authenticated, if you click several
     * times on like, it will only like once.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
   /* public function testSeveralLikeClicksUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',67)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',67);
            $this->assertDatabaseHas('replies', ['likectr' => 67]);
        });
    }*/

    /**
     * This test shows that when authenticated, if you click several
     * times on dislike, it will only like once.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    /*public function testSeveralDislikeClicksUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',125)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',125);
            $this->assertDatabaseHas('replies', ['dislikectr' => 125]);
        });
    }*/

    /**
     * This test shows that when you are the owner of a reply, you
     * cannot like your own reply.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
   /* public function testLikeOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66);
            $this->assertDatabaseHas('replies', ['likectr' => 66]);
        });
    }*/

    /**
     * This test shows that when you are the owner of a reply, you
     * cannot like your own reply. Even when you click several times.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
   /* public function testSeveralLikeClicksOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66)
                ->click('@like-1')
                ->pause(3000)
                ->assertSeeIn('@numlike-1',66);
            $this->assertDatabaseHas('replies', ['likectr' => 66]);
        });
    }*/

    /**
     * This test shows that when you are the owner of a reply, you
     * cannot dislike your own reply.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
   /* public function testDislikeOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124);
            $this->assertDatabaseHas('replies', ['dislikectr' => 124]);
        });
    }*/

    /**
     * This test shows that when you are the owner of a reply, you
     * cannot dislike your own reply. Even when you click several times.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    /*public function testSeveralDislikeClicksOwner()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertAuthenticated()
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124)
                ->click('@dislike-1')
                ->pause(3000)
                ->assertSeeIn('@numdislike-1',124);
            $this->assertDatabaseHas('replies', ['dislikectr' => 124]);
        });
    }*/
}
