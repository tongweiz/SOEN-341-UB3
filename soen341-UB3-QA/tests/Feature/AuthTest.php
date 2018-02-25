<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase;
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

    /**
     * Test the case where a user fails to register because of empty name
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureEmptyName(){
        $this->visit('/register')
            ->type('', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('secret123', 'password')
            ->type('secret123', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'email' => 'tester@gmail.com'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of empty email
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureEmptyEmail(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('', 'email')
            ->type('secret123', 'password')
            ->type('secret123', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'name' => 'tester'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of empty password
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureEmptyPassword(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('', 'password')
            ->type('secret123', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'email' => 'tester@gmail.com'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of empty confirm password
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureEmptyConfirmPassword(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('secret1234', 'password')
            ->type('', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'email' => 'tester@gmail.com'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of empty all fields
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureEmptyAllFields(){
        $this->visit('/register')
            ->type('', 'name')
            ->type('', 'email')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'email' => 'tester@gmail.com'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of invalid email. (no @)
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureInvalidEmail(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('s', 'email')
            ->type('secret1234', 'password')
            ->type('secret1234', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'name' => 'tester'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of invalid email. (no .domain)
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureInvalidEmail2(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('s@h', 'email')
            ->type('secret1234', 'password')
            ->type('secret1234', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'name' => 'tester'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of short password
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureShortPassword(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('s', 'password')
            ->type('s', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'name' => 'tester'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user fails to register because of different confirm password.
     * Confirms that the user stays on /register.
     * Confirms the user is not registered or logged in.
     */
    public function testRegistrationFailureDifferentConfirmPassword(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('secret1234', 'password')
            ->type('secret111111', 'password_confirmation')
            ->press('Register')
            ->seePageIs('http://localhost/register')
            ->dontSeeInDatabase('users', [
                'name' => 'tester'
            ])->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user logins successfully
     * Confirms that the user is redirected to /home.
     * Confirms that user was logged in.
     */
    public function testLoginSuccess(){

        //create new user
        factory(User::class)->create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('user1@gmail.com', 'email')
            ->type('secret1234', 'password')
            ->press('Login')
            ->isAuthenticated();
    }

    /**
     * Test the case where a user's login fails by email.
     * User stays on login page.
     * User is not authenticated.
     */
    public function testLoginFailureEmail(){

        //create new user
        factory(User::class)->create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('user3@gmail.com', 'email')
            ->type('secret1234', 'password')
            ->press('Login')
            ->seePageIs('http://localhost/login')
            ->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user's login fails by password.
     * User stays on login page.
     * User is not authenticated.
     */
    public function testLoginFailurePassword(){

        //create new user
        factory(User::class)->create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('user3@gmail.com', 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs('http://localhost/login')
            ->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user's login fails by email and password.
     * User stays on login page.
     * User is not authenticated.
     */
    public function testLoginFailurePasswordAndEmail(){

        //create new user
        factory(User::class)->create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('user4@gmail.com', 'email')
            ->type('failure', 'password')
            ->press('Login')
            ->seePageIs('http://localhost/login')
            ->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user's login fails by an empty email.
     * User stays on login page.
     * User is not authenticated.
     */
    public function testLoginFailureEmptyEmail(){

        //create new user
        factory(User::class)->create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('', 'email')
            ->type('secret1234', 'password')
            ->press('Login')
            ->seePageIs('http://localhost/login')
            ->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user's login fails by an empty password.
     * User stays on login page.
     * User is not authenticated.
     */
    public function testLoginFailureEmptyPassword(){

        //create new user
        factory(User::class)->create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('user3@gmail.com', 'email')
            ->type('', 'password')
            ->press('Login')
            ->seePageIs('http://localhost/login')
            ->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user's login fails by an empty password and email.
     * User stays on login page.
     * User is not authenticated.
     */
    public function testLoginFailureFieldsAllEmpty(){

        //create new user
        factory(User::class)->create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => 'secret1234',
        ]);

        $this->visit('/login')
            ->type('', 'email')
            ->type('', 'password')
            ->press('Login')
            ->seePageIs('http://localhost/login')
            ->dontSeeIsAuthenticated();
    }

    /**
     * Test the case where a user's logout.
     * User gets redirected to home
     * User is not authenticated anymore.
     */
    public function testLogoutSuccessfully(){
        $this->visit('/register')
            ->type('tester', 'name')
            ->type('tester@gmail.com', 'email')
            ->type('secret123', 'password')
            ->type('secret123', 'password_confirmation')
            ->press('Register');

        $this->visit('/logout')
              ->seePageIs('http://localhost/home')
              ->dontSeeIsAuthenticated();
    }
}