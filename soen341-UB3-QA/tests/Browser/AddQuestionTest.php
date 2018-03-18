<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\User;

class AddQuestionTest extends BrowserKitTestCase
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
            ->type('label1', 'labels')
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
            ->type('label1', 'labels')
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
            ->type('label1', 'labels')
            ->press('Submit')
            ->seePageIs('http://localhost/ask')
            ->dontSeeInDatabase('questions', [
                'title' => 'a title'])
            ->isAuthenticated();
    }

    /**
     * Test valid question gets saved properly when the labels are not
     * given by the user.
     */
    public function testSuccessValidNewQuestionNoLabels()
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
                'labels' => '',
                'id' => 1])
            ->isAuthenticated();
    }

    /**
     * Test valid question gets saved properly with multiple labels.
     */
    public function testSuccessValidNewQuestionAllFields()
    {
        $user = \App\User::find(1);

        $this->actingAs($user)
            ->visit('/ask')
            ->type('a title', 'title')
            ->type('some content', 'content')
            ->type('label_1,label_2', 'labels')
            ->press('Submit')
            ->seePageIs('http://localhost/home')
            ->seeInDatabase('questions', [
                'title' => 'a title',
                'content' => 'some content',
                'labels' => 'label_1,label_2',
                'id' => 1])
            ->isAuthenticated();
    }
}
