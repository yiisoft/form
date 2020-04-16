<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use Yiisoft\Form\Tests\Stub\LoginForm;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected LoginForm $loginForm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loginForm = new LoginForm();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->loginForm);
    }

    /**
     * Asserting two strings equality ignoring line endings.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     *
     * @return void
     */
    protected function assertEqualsWithoutLE(string $expected, string $actual, string $message = ''): void
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);

        $this->assertEquals($expected, $actual, $message);
    }
}
