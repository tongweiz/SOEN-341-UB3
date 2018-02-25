<?php

namespace Tests\Feature;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends BrowserKitTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Test the case where a user registers successfully
     * Confirms that the user is redirected to /home.
     * Confirms the user exists in the database.
     * Confirms that user was also logged in by registering.
     */
    public function testRegistrationSuccess(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('secret123', 'password')
            ->type('secret123', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/home')
            ->seeInDatabase('users', [
                'email' => 'tester@gmail.com'
            ])->isAuthenticated();
    }
}