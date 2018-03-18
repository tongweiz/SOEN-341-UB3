<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @throws
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
        $this->assertEquals('f', 'f');
        $this->assertDatabaseHas('users', ['name' => 'user1']);
    }
}
