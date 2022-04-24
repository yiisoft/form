<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\Tests\Support\Form\PasswordForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Password::widget()->attribute(new PasswordForm(), 'old')->render();
        $this->assertSame(
            <<<HTML
            <div>
            <label for="passwordform-old">Old password</label>
            <input type="password" id="passwordform-old" name="PasswordForm[old]" value>
            <div>Enter your old password.</div>
            </div>
            HTML,
            $result
        );
    }
}
