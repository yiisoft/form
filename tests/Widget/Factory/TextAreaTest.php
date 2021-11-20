<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\TextArea;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TextAreaTest extends TestCase
{
    use TestTrait;

    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" cols="50"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string'], 'cols()' => [50]])->render(),
        );
    }

    public function testDirname(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" dirname="test.dir"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string'], 'dirname()' => ['test.dir']])->render(),
        );
    }

    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        TextArea::widget(['for()' => [$this->formModel, 'string'], 'dirname()' => ['']])->render();
    }

    public function testImmutability(): void
    {
        $textArea = TextArea::widget();
        $this->assertNotSame($textArea, $textArea->cols(0));
        $this->assertNotSame($textArea, $textArea->dirname('test.dir'));
        $this->assertNotSame($textArea, $textArea->maxlength(0));
        $this->assertNotSame($textArea, $textArea->placeholder(''));
        $this->assertNotSame($textArea, $textArea->readOnly());
        $this->assertNotSame($textArea, $textArea->rows(0));
        $this->assertNotSame($textArea, $textArea->wrap('hard'));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" maxlength="100"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string'], 'maxlength()' => [100]])->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text"></textarea>',
            TextArea::widget([
                'for()' => [$this->formModel, 'string'], 'placeholder()' => ['PlaceHolder Text'],
            ])->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testTextAreaReadOnly(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" readonly></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string'], 'readOnly()' => []])->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->assertSame(
            '<textarea id="typeform-tonull" name="TypeForm[toNull]"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'toNull']])->render(),
        );

        // value string
        $this->formModel->setAttribute('string', 'hello');
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]">hello</textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        TextArea::widget(['for()' => [$this->formModel, 'array']])->render();
    }

    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="hard"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string'], 'wrap()' => []])->render(),
        );

        /** soft value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="soft"></textarea>',
            TextArea::widget(['for()' => [$this->formModel, 'string'], 'wrap()' => ['soft']])->render(),
        );
    }

    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::widget(['for()' => [$this->formModel, 'string'], 'wrap()' => ['exception']])->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
