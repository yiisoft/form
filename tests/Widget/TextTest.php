<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Text;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TextTest extends TestCase
{
    use TestTrait;

    public function testDirname(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" dirname="test.dir">',
            Text::widget()->for($this->formModel, 'string')->dirname('test.dir')->render(),
        );
    }

    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Text::widget()->for($this->formModel, 'string')->dirname('')->render();
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" form="form-id">',
            Text::widget()->for($this->formModel, 'string')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $text = Text::widget();
        $this->assertNotSame($text, $text->dirname('test.dir'));
        $this->assertNotSame($text, $text->form(''));
        $this->assertNotSame($text, $text->maxlength(0));
        $this->assertNotSame($text, $text->placeholder(''));
        $this->assertNotSame($text, $text->pattern(''));
        $this->assertNotSame($text, $text->readOnly());
        $this->assertNotSame($text, $text->size(0));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Text::widget()->for($this->formModel, 'string')->maxlength(10)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Text::widget()->for($this->formModel, 'string')->minlength(4)->render(),
        );
    }

    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="text" id="typeform-string" name="TypeForm[string]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]">
        HTML;
        $html = Text::widget()
            ->for($this->formModel, 'string')
            ->pattern('[A-Za-z]')
            ->title('Only accepts uppercase and lowercase letters.')
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Text::widget()->for($this->formModel, 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" readonly>',
            Text::widget()->for($this->formModel, 'string')->readOnly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]">',
            Text::widget()->for($this->formModel, 'string')->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" size="10">',
            Text::widget()->for($this->formModel, 'string')->size(10)->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->assertSame(
            '<input type="text" id="typeform-tonull" name="TypeForm[toNull]">',
            Text::widget()->for($this->formModel, 'toNull')->render(),
        );

        // value string
        $this->formModel->setAttribute('string', 'hello');
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" value="hello">',
            Text::widget()->for($this->formModel, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Text::widget()->for($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
