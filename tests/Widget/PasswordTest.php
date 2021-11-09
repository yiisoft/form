<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

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

    private TypeForm $formModel;

    public function testForm(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" form="form-id">',
            Password::widget()->config($this->formModel, 'string')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $password = Password::widget();
        $this->assertNotSame($password, $password->form(''));
        $this->assertNotSame($password, $password->maxlength(0));
        $this->assertNotSame($password, $password->minlength(0));
        $this->assertNotSame($password, $password->pattern(''));
        $this->assertNotSame($password, $password->placeHolder(''));
        $this->assertNotSame($password, $password->readOnly());
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" maxlength="16">',
            Password::widget()->config($this->formModel, 'string')->maxlength(16)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" minlength="8">',
            Password::widget()->config($this->formModel, 'string')->minlength(8)->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="password" id="typeform-string" name="TypeForm[string]" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        HTML;
        $html = Password::widget()
            ->config($this->formModel, 'string', [
                'title' => 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 ' .
                'or more characters.',
            ])
            ->pattern('(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}')
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Password::widget()->config($this->formModel, 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]" readonly>',
            Password::widget()->config($this->formModel, 'string')->readOnly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="password" id="typeform-string" name="TypeForm[string]">',
            Password::widget()->config($this->formModel, 'string')->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->assertSame(
            '<input type="password" id="typeform-tonull" name="TypeForm[toNull]">',
            Password::widget()->config($this->formModel, 'toNull')->render(),
        );

        // value string
        $this->formModel->setAttribute('string', '1234??');
        $this->assertSame(
            '<input type="password" id="typeform-tonull" name="TypeForm[toNull]">',
            Password::widget()->config($this->formModel, 'toNull')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password widget must be a string or null value.');
        Password::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
