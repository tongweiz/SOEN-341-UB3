<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    //to migrate db before each test
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     * @throws
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Questions!');
        });
    }
}
