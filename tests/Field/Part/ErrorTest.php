<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Tests\Support\Form\ErrorForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\Validator;
use Yiisoft\Widget\WidgetFactory;

final class ErrorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->render();

        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }

    public function testAttributeWithoutError(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'age')
            ->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->tag('b')
            ->render();

        $this->assertSame('<b>Value cannot be blank.</b>', $result);
    }

    public function testEmptyTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->tag('');
    }

    public function testTagAttributes(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->tagAttributes(['class' => 'red', 'data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Value cannot be blank.</div>', $result);
    }

    public function testEncode(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->message('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->message('<b>your name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<div><b>your name</b></div>', $result);
    }

    public function testCustomMessage(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->message('Invalid name.')
            ->render();

        $this->assertSame('<div>Invalid name.</div>', $result);
    }

    public function testCustomMessageWithoutError(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'age')
            ->message('Invalid name.')
            ->render();

        $this->assertSame('', $result);
    }

    public function testMessageCallback(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->messageCallback(
                static function (ErrorForm $form, string $attribute, string $message): string {
                    return 'Attribute "' . $attribute . '" error: ' . $message;
                }
            )
            ->render();

        $this->assertSame('<div>Attribute "name" error: Value cannot be blank.</div>', $result);
    }

    public function testMessageCallbackWithCustomMessage(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'name')
            ->message('Invalid value.')
            ->messageCallback(
                static function (ErrorForm $form, string $attribute, string $message): string {
                    return 'Attribute "' . $attribute . '" error: ' . $message;
                }
            )
            ->render();

        $this->assertSame('<div>Attribute "name" error: Invalid value.</div>', $result);
    }

    public function testMessageCallbackWithMessageAndWithoutError(): void
    {
        $result = Error::widget()
            ->attribute($this->createValidatedErrorForm(), 'age')
            ->message('Invalid value.')
            ->messageCallback(
                static function (ErrorForm $form, string $attribute, string $message): string {
                    return 'Attribute "' . $attribute . '" error: ' . $message;
                }
            )
            ->render();

        $this->assertSame('', $result);
    }

    private function createValidatedErrorForm(): ErrorForm
    {
        $form = new ErrorForm();
        (new Validator())->validate($form);
        return $form;
    }
}
