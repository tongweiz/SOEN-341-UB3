<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;
use Exception;

class ProfileTest extends DuskTestCase
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
            'avatar' => 1
        ]);

        //create user2
        factory(User::class)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'secret1234',
            'avatar' => 2
        ]);
    }

    /**
     * This test makes sure that if the database is empty,
     * that no question will appear in his profile page.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingNoQuestionInDatabase()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->assertSee('No questions were asked yet!');
        });
    }

    /**
     * This test makes sure that if the user didnt ask a question,
     * that no question will appear in his profile page.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingNoQuestionFromUser()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'labels' => 'label1,label3',
            'user_id' => 2,
            'nb_replies' => 0
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->assertSee('No questions were asked yet!');
        });
    }

    /**
     * This test makes sure that if the user HAS asked a question
     * the questions will appear in his profile page.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testListingUserQuestions()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'labels' => 'label1',
            'user_id' => 1,
            'nb_replies' => 0,
            'created_at' => '2018-03-17 12:20:00',
            'updated_at' => '2018-03-17 12:20:00'
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'labels' => 'label3',
            'user_id' => 1,
            'nb_replies' => 0,
            'created_at' => '2018-03-17 13:00:00',
            'updated_at' => '2018-03-17 13:00:00'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->assertSee('first title test')
                ->assertSee('first content')
                ->assertSee('label1')
                ->assertSee('0 replies')
                ->assertSee('Posted on the 17th of March of 2018 at 12:20:00 by user1')
                ->assertSee('second title test')
                ->assertSee('second content')
                ->assertSee('label3')
                ->assertSee('0 replies')
                ->assertSee('Posted on the 17th of March of 2018 at 13:00:00 by user1');
        });
    }

    /**
     * This test makes sure that the cancel button of the edit
     * widget will not change user name even if value was changed in input.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testCancelButtonNameNotSaved()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@name-input', 'test')
                ->click('@cancel-button');
                $this->assertDatabaseMissing('users', ['name' => 'test']);
        });
    }

    /**
     * This test makes sure that the cancel button of the edit
     * widget will not change user email even if value was changed in input.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testCancelButtonEmailNotSaved()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@email-input', 'i@gmail.com')
                ->click('@cancel-button');
            $this->assertDatabaseMissing('users', ['email' => 'i@gmail.com']);
        });
    }

    /**
     * This test makes sure that the cancel button of the edit
     * widget will not change user password even if value was changed in input.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testCancelButtonPasswordNotSaved()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@password-input', 'secret123')
                ->click('@cancel-button');
            $this->assertDatabaseMissing('users', ['password' => bcrypt('secret123')]);
        });
    }

    /**
     * This test makes sure that an empty name cannot be taken as the
     * new value.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonEmptyName()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@name-input', '')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['name' => '']);
        });
    }

    /**
     * This test makes sure that an empty email cannot be taken as the
     * new value.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonEmptyEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@email-input', '')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['email' => '']);
        });
    }

    /**
     * This test makes sure that the user's name can be changed.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonChangeName()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@name-input', 'newname')
                ->click('@save-button')
                ->pause(3000)
                ->assertDontSee('ERRORS');
            $this->assertDatabaseHas('users', ['name' => 'newname']);
        });
    }

    /**
     * This test makes sure that the user's email can be changed.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonChangeEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@email-input', 'newemail@gmail.com')
                ->click('@save-button')
                ->pause(3000)
                ->assertDontSee('ERRORS');
            $this->assertDatabaseHas('users', ['email' => 'newemail@gmail.com', 'name' => 'user1']);
        });
    }

    /**
     * This test makes sure that the new email must have an @ symbol
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonEmailNoSymbol()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@email-input', 'newemail.com')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['email' => 'newemail.com']);
        });
    }

    /**
     * This test makes sure that the new email must have an .com
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonEmailNoCom()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@email-input', 'newemail@gmail')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['email' => 'newemail@gmail']);
        });
    }

    /**
     * This test makes sure that if all fields are empty,
     * no change will pass through
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonAllEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@email-input', '')
                ->type('@name-input', '')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['email' => '', 'name' => '']);
        });
    }

    /**
     * This test makes sure that the a password with less than
     * 6 character cannot be taken.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonShortPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@password-input', 'user1')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['password' => bcrypt('user1')]);
        });
    }

    /**
     * This test makes sure that the a password with no numbers
     * will not be taken.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonNoNumbersPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@password-input', 'usersss')
                ->click('@save-button')
                ->assertSee('ERRORS');
            $this->assertDatabaseMissing('users', ['password' => bcrypt('userss')]);
        });
    }

    /**
     * This test makes sure that the a password with more than
     * 6 characters including a number will be changed in the database.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonChangePassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@password-input', 'secret123')
                ->click('@save-button')
                ->assertDontSee('ERRORS');
            $this->assertDatabaseMissing('users', ['name' => 'user1',
                'email' => 'user1@gmail.com', 'password' => bcrypt('secret1234')]);
        });
    }

    /**
     * This test makes sure that the a password with more than
     * 6 characters including a number will be changed in the database.
     *
     * @throws Exception if operation fail
     * @throws \Throwable if operation fail
     */
    public function testSaveButtonChangeAllFields()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(\App\User::find(1))
                ->visit('/profile')
                ->click('@edit-button')
                ->type('@password-input', 'secret123')
                ->type('@name-input', 'newuser')
                ->type('@email-input', 'email@gmail.com')
                ->click('@save-button')
                ->assertDontSee('ERRORS');
            $this->assertDatabaseMissing('users', ['name' => 'newuser', 'email' => 'email@gmail.com',
                'password' => bcrypt('secret1234')]);
        });
    }





}