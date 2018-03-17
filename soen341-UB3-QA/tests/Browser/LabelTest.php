<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;
use Exception;

class LabelTest extends DuskTestCase
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
            'nb_replies' => 0
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'labels' => 'label2',
            'user_id' => 1,
            'nb_replies' => 0
        ]);
    }

    /**
     * This test shows that the labels of questions appear on the sidebar
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingAllLabels()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->assertSeeIn('@filter-labels-label1', 'label1')
                ->assertSeeIn('@filter-labels-label2', 'label2')
                ->assertSeeIn('@filter-labels-label3', 'label3');
        });
    }

    /**
     * This test shows that the labels of questions appear on the sidebar even
     * if user entered them with a lot of spaces.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingAllLabelsTrimmed()
    {
        factory(Question::class)->create([
            'title' => 'third title test',
            'content' => 'third content',
            'labels' => '      label10      ,    label20   ',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->assertSeeIn('@filter-labels-label10', 'label10')
                ->assertSeeIn('@filter-labels-label20', 'label20');
        });
    }

    /**
     * Tests shows that when a label is clicked, it only shows the
     * one question with that specific label
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayQuestionWithSpecificLabel()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@filter-labels-label1')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertDontSee('second title test')
                ->assertDontSee('second content');
        });
    }

    /**
    * Tests shows that when a label is clicked, it only shows
    * all questions with that specific label
    *
    * @throws Exception if operation fail
    * @throws \Throwable if operation fail
    */
    public function testDisplaySeveralQuestionsWithSpecificLabel()
    {
        factory(Question::class)->create([
            'title' => 'third title test',
            'content' => 'third content',
            'labels' => 'label1',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@filter-labels-label1')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertDontSee('second title test')
                ->assertDontSee('second content')
                ->assertSee('third title test')
                ->assertSee('third content');
        });
    }

    /**
     * Tests shows that when a label is clicked TWICED, it shows
     * all questions in database. no filtering.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayAllQuestionsLabelClickedTwice()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->click('@filter-labels-label1')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertDontSee('second title test')
                ->assertDontSee('second content')
                ->pause(3000)
                ->click('@filter-labels-label1')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertSee('second title test')
                ->assertSee('second content');
        });
    }
}