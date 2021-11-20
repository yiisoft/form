<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Password;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PasswordTest extends TestCase
{
    use TestTrait;

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" maxlength="16">',
            Password::widget(['for()' => [$this->formModel, 'string'], 'maxlength()' => [16]])->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" minlength="8">',
            Password::widget(['for()' => [$this->formModel, 'string'], 'minlength()' => [8]])->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="password" id="typeform-string" name="TypeForm[string]" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        HTML;
        $this->assertSame(
            $expected,
            Password::widget([
                'for()' => [$this->formModel, 'string'],
                'title()' => [
                    'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more ' .
                    'characters.',
                ],
                'pattern()' => ['(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'],
            ])->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Password::widget([
                'for()' => [$this->formModel, 'string'],
                'placeholder()' => ['PlaceHolder Text'],
            ])->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" readonly>',
            Password::widget()->for($this->formModel, 'string')->readonly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]">',
            Password::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" size="3">',
            Password::widget(['for()' => [$this->formModel, 'string'], 'size()' => [3]])->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->assertSame(
            '<input type="password" id="typeform-tonull" name="TypeForm[toNull]">',
            Password::widget(['for()' => [$this->formModel, 'toNull']])->render(),
        );

        // value string
        $this->formModel->setAttribute('string', '1234??');
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" value="1234??">',
            Password::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Password::widget(['for()' => [$this->formModel, 'array']])->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
