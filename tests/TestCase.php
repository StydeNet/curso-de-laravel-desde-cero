<?php

namespace Tests;

use Illuminate\Testing\TestResponse;
use Styde\Enlighten\Tests\EnlightenSetup;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers, DetectRepeatedQueries, EnlightenSetup;

    protected $defaultData = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->addTestResponseMacros();

        $this->withoutExceptionHandling();

        $this->enableQueryLog();

        $this->setUpEnlighten();
    }

    protected function tearDown(): void
    {
        $this->flushQueryLog();

        parent::tearDown();
    }

    protected function addTestResponseMacros()
    {
        TestResponse::macro('viewData', function ($key) {
            $this->ensureResponseHasView();
            $this->assertViewHas($key);
            return $this->original->$key;
        });

        TestResponse::macro('assertViewCollection', function ($var) {
            return new TestCollectionData($this->viewData($var));
        });
    }
}
