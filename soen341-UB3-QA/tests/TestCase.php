<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
    * The base URL of the application.
    *
    * @var string
    */

    public $baseUrl = 'http://localhost';
}
