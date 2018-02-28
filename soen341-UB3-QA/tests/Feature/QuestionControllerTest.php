<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;
use App\User;

class QuestionControllerTest extends BrowserKitTestCase
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
     */
    public function testListingNoQuestions()
    {
        //no question is being showed because database is empty
        $this->visit('/home')
             ->see('No question has been asked on the website yet!');
    }

    /**
     * This test shows that all questions in the database will be showed on the home
     * page listing as a guest. Question title and who posted it are shown.
     */
    public function testListingAllQuestionsAsGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1,
        ]);

        $this->visit('/home')
            ->see('first title test')
            ->dontSee('first content')
            ->see('user1')
            ->see('second title test')
            ->dontSee('second content');
    }

    /**
     * This test shows that all questions in the database will be showed on the home
     * page listing as an authenticated user. Question title and who posted it are shown.
     */
    public function testListingAllQuestionsAsUser()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1,
        ]);

        $user = \App\User::find(1);

        $this->actingAs($user)
            ->visit('/home')
            ->see('first title test')
            ->dontSee('first content')
            ->see('user1')
            ->see('second title test')
            ->dontSee('second content')
            ->isAuthenticated();
    }

    /*
     * This test shows that when not authenticated, a user's question
     * will not be added to the database.
     */
    public function testFailureAddQuestionNotAuthenticated()
    {
        $this->visit('/ask')
             ->type('This is a title', 'title')
             ->type('This is the associated content', 'content')
             ->press('Submit')
             ->seePageIs('http://localhost/ask')
             ->dontSeeInDatabase('questions', [
                'title' => 'This is a title']);
    }

    /**
     * This test shows that when authenticated, question still needs a title
     * to be valid.
     */
    public function testFailureAddQuestionNoTitle()
    {
        $user = \App\User::find(1);

        $this->actingAs($user)
            ->visit('/ask')
            ->type('', 'title')
            ->type('some content', 'content')
            ->press('Submit')
            ->seePageIs('http://localhost/ask')
            ->dontSeeInDatabase('questions', [
                'content' => 'some content'])
            ->isAuthenticated();
    }

    /**
     * This test shows that when authenticated, question still needs a content
     * to be valid.
     */
    public function testFailureAddQuestionNoContent()
    {
        $user = \App\User::find(1);

        $this->actingAs($user)
            ->visit('/ask')
            ->type('a title', 'title')
            ->type('', 'content')
            ->press('Submit')
            ->seePageIs('http://localhost/ask')
            ->dontSeeInDatabase('questions', [
                'title' => 'a title'])
            ->isAuthenticated();
    }

    /**
     * Test valid question gets saved properly.
     */
    public function testSuccessValidNewQuestion()
    {
        $user = \App\User::find(1);

        $this->actingAs($user)
            ->visit('/ask')
            ->type('a title', 'title')
            ->type('some content', 'content')
            ->press('Submit')
            ->seePageIs('http://localhost/home')
            ->seeInDatabase('questions', [
                'title' => 'a title',
                'content' => 'some content',
                'id' => 1])
            ->isAuthenticated();
    }

    /**
     * Tests whether all the necessary question information is displayed as a guest.
     * Question has no replies.
     */
    public function testDisplayQuestionInfoWithoutRepliesAsAGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        $this->visit('/questions/1')
             ->see('first title test')
             ->see('user1')
             ->see('2018-02-02 12:20:00')
             ->see('first content')
             ->see('No comments');
    }

    /**
     * Tests whether all the necessary question information is displayed.
     * Question has replies.
     */
    public function testDisplayQuestionInfoWithRepliesAsAGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
        ]);

        $this->visit('/questions/1')
            ->see('first title test')
            ->see('user1')
            ->see('2018-02-02 12:20:00')
            ->see('first content')
            ->see('first reply')
            ->see(66)
            ->see(124);
    }

    /**
     * Tests whether all the necessary question information is displayed as
     * an authenticated user.
     * Question has no replies.
     */
    public function testDisplayQuestionInfoAsAUser()
    {
        $user = \App\User::find(2);

        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
        ]);

        $this->actingAs($user)
             ->visit('/questions/1')
             ->see('first title test')
             ->see('user1')
             ->see('2018-02-02 12:20:00')
             ->see('first content')
             ->see('first reply')
             ->see(66)
             ->see(124);
    }

    /**
     * Test to check if you see accepted symbol next to the replies
     * as a guest.
     */
    public function testDisplayAcceptedIconAsGuest()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 1,
        ]);

        $this->visit('/questions/1')
             ->seeText('<i class="fa fa-ban <?php echo \'fa-2x\'; ?>"></i>');
    }

    /**
     * Test to check if you see accepted symbol next to the replies
     * as not the owner of the question.
     */
    public function testDisplayAcceptedIconAsNotTheOwner()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1,
            'created_at' => '2018-02-02 12:20:00',
        ]);

        factory(Reply::class)->create([
            'content' => 'first reply',
            'question_id' => 1,
            'user_id' => 2,
            'likectr' => 66,
            'dislikectr' => 124,
            'status' => 1,
        ]);

        $user = \App\User::find(2);

        $this->actingAs($user)
             ->visit('/questions/1')
             ->seeText('<i class="fa fa-ban <?php echo \'fa-2x\'; ?>"></i>');
    }

}
