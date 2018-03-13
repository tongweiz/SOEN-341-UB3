<?php

namespace Tests\Browser;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;
use Exception;

class QuestionControllerTest extends DuskTestCase
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
    }

    /**
     * This test shows that no questions will be showed on the home page
     * if the database is empty.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingNoQuestions()
    {
        //no question is being showed because database is empty
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->assertSee('No questions were asked yet!');
        });
    }

    /**
     * This test shows that all questions in the database will be showed on the home
     * page listing as a guest. Question title, content and who posted it are shown.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingAllQuestionsAsGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);


        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertSee('user1')
                ->assertSee('second title test')
                ->assertSee('second content')
                ->assertSee('user1');
        });
    }

    /**
     * This test shows that all questions in the database will be showed on the home
     * page listing as an authenticated user. Question title, content and who posted it are shown.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingAllQuestionsAsUser()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/home')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertSee('user1')
                ->assertSee('second title test')
                ->assertSee('second content')
                ->assertSee('user1')
                ->assertAuthenticatedAs(\App\User::find(1));
        });
    }

    /**
     * This test shows that the labels of questions appear on the sidebar
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingAllLabels()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'labels' => 'label1, label3',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'labels' => 'label2',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->seeLink('label1')
                ->seeLink('label2')
                ->seeLink('label3');
        });
    }

    /**
     * This test shows that when not authenticated, a user's question
     * will not be added to the database.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testFailureAddQuestionNotAuthenticated()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/ask')
                ->type('title', 'This is a title')
                ->type('content', 'This is the associated content')
                ->type('labels', 'label1')
                ->press('Submit')
                ->assertPathIs('http://localhost/ask');
        });

        $this->browse(function (Browser $browser) {
            $this->assertDatabaseMissing('questions', [
                'content' => 'This is the associated content']);
        });
    }

    /**
     * This test shows that when authenticated, question still needs a title
     * to be valid.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testFailureAddQuestionNoTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/ask')
                ->type('title', '')
                ->type('content', 'some content')
                ->type('labels', 'label1')
                ->press('Submit')
                ->assertPathIs('http://localhost/ask')
                ->assertAuthenticatedAs(\App\User::find(1));
        });

        $this->browse(function (Browser $browser) {
            $this->assertDatabaseMissing('questions', [
                'content' => 'some content']);
        });
    }

    /**
     * This test shows that when authenticated, question still needs a content
     * to be valid.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testFailureAddQuestionNoContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/ask')
                ->type('title', 'a title')
                ->type('content', '')
                ->type('labels', 'label1')
                ->press('Submit')
                ->assertPathIs('http://localhost/ask')
                ->assertAuthenticatedAs(\App\User::find(1));
        });

        $this->browse(function (Browser $browser) {
            $this->assertDatabaseMissing('questions', [
                'title' => 'a title']);
        });
    }


    /**
     * Test valid question gets saved properly when the labels are not
     * given by the user.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSuccessValidNewQuestionNoLabels()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/ask')
                ->type('title', 'a title')
                ->type('content', 'some content')
                ->press('Submit')
                ->assertPathIs('http://localhost/home')
                ->assertAuthenticatedAs(\App\User::find(1));
        });

        $this->browse(function (Browser $browser) {
            $this->assertDatabaseHas('questions', [
                'title' => 'a title',
                'content' => 'some content',
                'labels' => '',
                'id' => 1]);
        });
    }

    /**
     * Test valid question gets saved properly when all fields are filled.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSuccessValidNewQuestionAllFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/ask')
                ->type('title', 'a title')
                ->type('content', 'some content')
                ->type('labels', 'label_1')
                ->press('Submit')
                ->assertPathIs('http://localhost/home')
                ->assertAuthenticatedAs(\App\User::find(1));
        });

        $this->browse(function (Browser $browser) {
            $this->assertDatabaseHas('questions', [
                'title' => 'a title',
                'content' => 'some content',
                'labels' => 'label_1',
                'id' => 1]);
        });
    }

    /**
     * Test valid question gets saved properly when more than one
     * label is given during question creation.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSuccessValidNewQuestionMultipleLabels()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/ask')
                ->type('title', 'a title')
                ->type('content', 'some content')
                ->type('labels', 'label1,label2')
                ->press('Submit')
                ->assertPathIs('http://localhost/home')
                ->assertAuthenticatedAs(\App\User::find(1));
        });

        $this->browse(function (Browser $browser) {
            $this->assertDatabaseHas('questions', [
                'title' => 'a title',
                'content' => 'some content',
                'labels' => 'label1,label2',
                'id' => 1]);
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
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'labels' => 'label1, label3',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'labels' => 'label2',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->clickLink('label1')
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
            'title' => 'first title test',
            'content' => 'first content',
            'labels' => 'label1, label3',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'labels' => 'label1',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        factory(Question::class)->create([
            'title' => 'third title test',
            'content' => 'third content',
            'labels' => 'label26',
            'user_id' => 1,
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->clickLink('label1')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertSee('second title test')
                ->assertSee('second content')
                ->assertDontSee('third title test')
                ->assertDontSee('third content');
        });
    }

    /**
     * Tests whether all the necessary question information is displayed as a guest.
     * Question has no replies.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayQuestionInfoWithoutRepliesAsAGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertSee('first title test')
                ->assertSee('user1')
                ->assertSee('first content')
                ->assertSee('No comments')
                ->assertSee('02th of February of 2018 at  12:20:00');
        });
    }

    /**
     * Tests whether all the necessary question information is displayed.
     * Question has replies.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayQuestionInfoWithRepliesAsAGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 0,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertSee('first title test')
                ->assertSee('user1')
                ->assertSee('first content')
                ->assertSee('No comments')
                ->assertSee('02th of February of 2018 at  12:20:00')
                ->assertSee(66)
                ->assertSee(124);
        });
    }

    /**
     * Tests whether all the necessary question information is displayed as
     * an authenticated user.
     * Question has no replies.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayQuestionInfoAsAUser()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertSee('first title test')
                ->assertSee('user1')
                ->assertSee('02th of February of 2018 at 12:20:00')
                ->assertSee('first content')
                ->assertSee('first reply')
                ->assertSee(66)
                ->assertSee(124);
        });
    }

    /**
     * Test to check if you see accepted symbol next to the replies
     * as a guest.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayAcceptedIconAsGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 1,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertVisible('.fa fa-check-circle fa-2x');
        });
    }

    /**
     * Test to check if you see accepted symbol next to the replies
     * as not the owner of the question.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayAcceptedIconAsNotTheOwner()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 1,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertVisible('.fa fa-check-circle fa-2x');
        });
    }

    /**
     * Test to check if you see rejected symbol next to the replies
     * as a guest.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayRejectedIconAsGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => -1,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/question/1')
                ->assertVisible('.fa fa-ban fa-2x');
        });
    }

    /**
     * Test to check if you see rejected symbol next to the replies
     * as not the owner of the question.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayRejectedIconAsNotTheOwner()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => -1,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(2))
                ->visit('/question/1')
                ->assertVisible('.fa fa-ban fa-2x');
        });
    }

    /**
     * This test checks if the normalize symbol is displayed next to a reply
     * when you are the owner of a question.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayNormalizeSymbolsAsOwner()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 0,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertVisible('.fa fa-bars fa-2x');
        });
    }

    /**
     * This test checks if the accept symbol is displayed next to a reply
     * when you are the owner of a question.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayAcceptSymbolsAsOwner()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 1,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertVisible('.fa fa-check-circle fa-2x');
        });
    }

    /**
     * This test checks if the reject symbol is displayed next to a reply
     * when you are the owner of a question.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testDisplayRejectSymbolsAsOwner()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
            'nb_replies' => 1,
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => -1,
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/question/1')
                ->assertVisible('.fa fa-ban fa-2x');
        });
    }
}
