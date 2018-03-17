<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Question;
use App\User;

class SearchTest extends DuskTestCase
{
    //will rollback db after every test
    //When run LOCALLY: have the db and tables setup but no data.
    use DatabaseMigrations;

    //set up environment for tests
    public function setUp()
    {
        parent::setUp();

        //create new use
        factory(User::class)->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'secret123'
        ]);

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
    }

    /**
     * Test the case where a user's searches empty string in search bar
     * User stays on home page.
     * User should see both questions in database.
     * @throws
     */
    public function testSearchEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', '')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches a word that matches no title.
     * User stays on home page.
     * User should see no questions.
     * @throws
     */
    public function testSearchMatchWordZero()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'elephant')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertDontSee('first title test')
                ->assertDontSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches a word that matches only one question.
     * User stays on home page.
     * User should see first question.
     * @throws
     */
    public function testSearchMatchWordOne()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'first')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertDontSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches a word that matches all questions.
     * User stays on home page.
     * User should see both questions.
     * @throws
     */
    public function testSearchMatchWordAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'test')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches a part of a word that matches no question.
     * User stays on home page.
     * User should see no questions.
     * @throws
     */
    public function testSearchMatchPartWordZero()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'el')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertDontSee('first title test')
                ->assertDontSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches a part of a word that matches one question.
     * User stays on home page.
     * User should see only first question.
     * @throws
     */
    public function testSearchMatchPartWordOne()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'ir')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertDontSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches a part of a word that matches all questions.
     * User stays on home page.
     * User should sees all questions.
     * @throws
     */
    public function testSearchMatchPartWordAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'es')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches multiple words that matches no questions.
     * User stays on home page.
     * User should see no questions.
     * @throws
     */
    public function testSearchMatchMultipleWordsZero()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'test failure')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertDontSee('first title test')
                ->assertDontSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches multiple words that matches one question only.
     * User stays on home page.
     * User should see first question.
     * @throws
     */
    public function testSearchMatchMultipleWordsOne()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'first title')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertDontSee('second title test');
        });
    }

    /**
     * Test the case where a user's searches multiple words that matches all questions.
     * User stays on home page.
     * User should see all questions.
     * @throws
     */
    public function testSearchMatchMultipleWordsAll()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                ->type('search', 'title test')
                ->press('Go!')
                ->assertPathIs('/home')
                ->assertSee('first title test')
                ->assertSee('second title test');
        });
    }
}
