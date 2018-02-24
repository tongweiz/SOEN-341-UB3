<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example that checks that you get to home page and you dont see the default laravel page.
     * We already modified the home page.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->visit('/')->dontSee('Laravel');
    }
}
