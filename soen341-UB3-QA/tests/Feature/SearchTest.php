<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;

class SearchTest extends BrowserKitTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    //set up environment for tests
    public function setUp()
    {
        parent::setUp();

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
    }

    /**
     * Test the case where a user's searches empty string in search bar
     * User stays on home page.
     * User should see both questions in database.
     */
    public function testSearchEmpty()
    {
        $this->visit('/home')
            ->type('', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home');
        
        $this->see('first title test')
             ->see('second title test');
    }

    /**
     * Test the case where a user's searches a word that matches no title.
     * User stays on home page.
     * User should see no questions.
     */
    public function testSearchMatchWordZero()
    {
        $this->visit('/home')
            ->type('elephant', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->dontSee('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches a word that matches only one question.
     * User stays on home page.
     * User should see first question.
     */
    public function testSearchMatchWordOne()
    {
        $this->visit('/home')
            ->type('first', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->see('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches a word that matches all questions.
     * User stays on home page.
     * User should see both questions.
     */
    public function testSearchMatchWordAll()
    {
        $this->visit('/home')
            ->type('test', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->see('first title test')
            ->see('second title test');
    }

    /**
     * Test the case where a user's searches a part of a word that matches no question.
     * User stays on home page.
     * User should see no questions.
     */
    public function testSearchMatchPartWordZero()
    {
        $this->visit('/home')
            ->type('el', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->dontSee('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches a part of a word that matches one question.
     * User stays on home page.
     * User should see only first question.
     */
    public function testSearchMatchPartWordOne()
    {
        $this->visit('/home')
            ->type('ir', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->see('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches a part of a word that matches all questions.
     * User stays on home page.
     * User should sees all questions.
     */
    public function testSearchMatchPartWordAll()
    {
        $this->visit('/home')
            ->type('es', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->see('first title test')
            ->see('second title test');
    }

    /**
     * Test the case where a user's searches multiple words that matches no questions.
     * User stays on home page.
     * User should see no questions.
     */
    public function testSearchMatchMultipleWordsZero()
    {
        $this->visit('/home')
            ->type('test failure', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->dontSee('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches multiple words that matches one question only.
     * User stays on home page.
     * User should see first question.
     */
    public function testSearchMatchMultipleWordsOne()
    {
        $this->visit('/home')
            ->type('first title', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->see('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches multiple words that matches all questions.
     * User stays on home page.
     * User should see all questions.
     */
    public function testSearchMatchMultipleWordsAll()
    {
        $this->visit('/home')
            ->type('title test', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->see('first title test')
            ->see('second title test');
    }
}
