<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Email;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class EmailTest extends TestCase
{
    use TestTrait;

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Email::widget(['for()' => [$this->formModel, 'string'], 'maxlength()' => [10]])->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Email::widget(['for()' => [$this->formModel, 'string'], 'minlength()' => [4]])->render(),
        );
    }

    public function testMultiple(): void
    {
        $this->formModel->setAttribute('string', 'email1@example.com;email2@example.com;');
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" value="email1@example.com;email2@example.com;" multiple>',
            Email::widget(['for()' => [$this->formModel, 'string'], 'multiple()' => [true]])->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="email" id="typeform-string" name="TypeForm[string]" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}">
        HTML;
        $html =
        $this->assertSame(
            $expected,
            Email::widget([
                'for()' => [$this->formModel, 'string'],
                'pattern()' => ['[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}'],
            ])->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Email::widget(['for()' => [$this->formModel, 'string'], 'placeholder()' => ['PlaceHolder Text']])->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]">',
            Email::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" size="20">',
            Email::widget(['for()' => [$this->formModel, 'string'], 'size()' => [20]])->render(),
        );
    }

    public function testValue(): void
    {
        // string 'email1@example.com;'
        $this->formModel->setAttribute('string', 'email1@example.com;');
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" value="email1@example.com;">',
            Email::widget(['for()' => [$this->formModel, 'string']])->render(),
        );

        // value null
        $this->formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]">',
            Email::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email widget must be a string or null value.');
        Email::widget(['for()' => [$this->formModel, 'int']])->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
