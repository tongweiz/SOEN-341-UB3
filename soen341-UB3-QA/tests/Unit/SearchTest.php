<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
use App\Question;

class SearchTest extends BrowserKitTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Test the case where a user's searches empty string in search bar
     * User stays on home page.
     * User should see both questions in database.
     */
    public function testSearchEmpty()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->seeText('second title test');
    }

    /**
     * Test the case where a user's searches a word that matches no title.
     * User stays on home page.
     * User should see no questions.
     */
    public function testSearchMatchWordZero()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

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
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('first', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches a word that matches all questions.
     * User stays on home page.
     * User should see both questions.
     */
    public function testSearchMatchWordAll()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('test', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->seeText('second title test');
    }

    /**
     * Test the case where a user's searches a part of a word that matches no question.
     * User stays on home page.
     * User should see no questions.
     */
    public function testSearchMatchPartWordZero()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

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
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('ir', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches a part of a word that matches all questions.
     * User stays on home page.
     * User should sees all questions.
     */
    public function testSearchMatchPartWordAll()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('es', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->seeText('second title test');
    }

    /**
     * Test the case where a user's searches multiple words that matches no questions.
     * User stays on home page.
     * User should see no questions.
     */
    public function testSearchMatchMultipleWordsZero()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

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
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('first title', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->dontSee('second title test');
    }

    /**
     * Test the case where a user's searches multiple words that matches all questions.
     * User stays on home page.
     * User should see all questions.
     */
    public function testSearchMatchMultipleWordsAll()
    {
        factory(Question::class)->create([
            'title' => 'first title test',
            'content' => 'first content',
            'user_id' => 1
        ]);

        factory(Question::class)->create([
            'title' => 'second title test',
            'content' => 'second content',
            'user_id' => 1
        ]);

        $this->visit('/home')
            ->type('title test', 'search')
            ->press('Go!')
            ->seePageIs('http://localhost/home')
            ->seeText('first title test')
            ->seeText('second title test');
    }
}
