<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use Yiisoft\Form\Tests\Stubs\LoginForm;

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
}
