<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use Yiisoft\Di\Container;
use Yiisoft\Form\Tests\Stub\LoginForm;
use Yiisoft\Widget\WidgetFactory;

class TestCase extends \PHPUnit\Framework\TestCase
{
    private Container $container;
    protected LoginForm $loginForm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container();
        $this->loginForm = new LoginForm();

        WidgetFactory::initialize($this->container, []);
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
