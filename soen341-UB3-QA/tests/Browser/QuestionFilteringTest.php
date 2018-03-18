<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;
use Exception;

class QuestionFilteringTest extends DuskTestCase
{
    //migrate db after every test
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        //create user1
        factory(User::class)->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'secret1234',
        ]);

        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'labels' => 'label1,label3',
            'user_id' => 1,
            'created_at' => '2018-03-17 12:20:00',
            'updated_at' => '2018-03-17 14:00:00',
            'nb_replies' => 3
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'labels' => 'label2',
            'user_id' => 1,
            'created_at' => '2018-03-17 13:00:00',
            'updated_at' => '2018-03-17 13:15:00',
            'nb_replies' => 2
        ]);

        factory(Question::class)->create([
            'title' => 'third title test',
            'content' => 'third content',
            'labels' => 'something',
            'user_id' => 1,
            'created_at' => '2018-03-16 13:00:00',
            'updated_at' => '2018-03-18 13:15:00',
            'nb_replies' => 9
        ]);
    }

    /** In this tests, the order of questions is checked with the assertVisible assertions.
        Every question has a dusk attribute with their title and their position in the list.
        We are checking if this pair <title>-<number> is on the page, hence in that position.**/

    /**
     * This test shows that the labels are by default filtered.
     * (Date created, ascending).
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDefaultFiltering()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->assertVisible('@third title test-0')
                    ->assertVisible('@first title test-1')
                    ->assertVisible('@second title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * last updated and ascending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testLastUpdatedAscending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@lastupdated')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@ascending')
                ->pause(3000)
                ->assertVisible('@second title test-0')
                ->assertVisible('@first title test-1')
                ->assertVisible('@third title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * last updated and descending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testLastUpdatedDescending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@lastupdated')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@descending')
                ->pause(3000)
                ->assertVisible('@third title test-0')
                ->assertVisible('@first title test-1')
                ->assertVisible('@second title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * title and ascending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testTitleAscending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@title')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@ascending')
                ->pause(3000)
                ->assertVisible('@first title test-0')
                ->assertVisible('@second title test-1')
                ->assertVisible('@third title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * title and descending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testTitleDescending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@title')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@descending')
                ->pause(3000)
                ->assertVisible('@third title test-0')
                ->assertVisible('@second title test-1')
                ->assertVisible('@first title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * number of replies and ascending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRepliesAscending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@numreplies')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@ascending')
                ->pause(3000)
                ->assertVisible('@second title test-0')
                ->assertVisible('@first title test-1')
                ->assertVisible('@third title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * number of replies and descending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testRepliesDescending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@numreplies')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@descending')
                ->pause(3000)
                ->assertVisible('@third title test-0')
                ->assertVisible('@first title test-1')
                ->assertVisible('@second title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * date created and ascending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDateCreatedAscending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@datecreated')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@ascending')
                ->pause(3000)
                ->assertVisible('@third title test-0')
                ->assertVisible('@first title test-1')
                ->assertVisible('@second title test-2');
        });
    }

    /**
     * This test shows the order of the question when filtered by
     * date created and descending
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDateCreatedDescending()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@dropdown1')
                ->click('@datecreated')
                ->pause(3000)
                ->click('@dropdown2')
                ->click('@descending')
                ->pause(3000)
                ->assertVisible('@second title test-0')
                ->assertVisible('@first title test-1')
                ->assertVisible('@third title test-2');
        });
    }
}