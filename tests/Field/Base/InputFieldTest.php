<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Form\Tests\Support\StubInputField;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class InputFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testWithoutFormModel(): void
    {
        $widget = StubInputField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form model is not set.');
        $widget->render();
    }

    public function testForm(): void
    {
        $result = StubInputField::widget()
            ->formAttribute(new TextForm(), 'company')
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="textform-company">Company</label>
            <input type="text" id="textform-company" name="TextForm[company]" value form="CreatePost">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataInputClass(): array
    {
        return [
            [' class="main"', []],
            [' class="main"', ['main']],
            [' class="main bold"', ['bold']],
            [' class="main italic bold"', ['italic bold']],
            [' class="main italic bold"', ['italic', 'bold']],
        ];
    }

    /**
     * @dataProvider dataInputClass
     *
     * @param string[] $class
     */
    public function testInputClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubInputField::widget()
            ->formAttribute(new TextForm(), 'company')
            ->inputClass('main')
            ->inputClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="textform-company">Company</label>
            <input type="text" id="textform-company"$expectedClassAttribute name="TextForm[company]" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataInputNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataInputNewClass
     */
    public function testInputNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = StubInputField::widget()
            ->formAttribute(new TextForm(), 'company')
            ->inputClass($class)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="textform-company">Company</label>
            <input type="text" id="textform-company"$expectedClassAttribute name="TextForm[company]" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataReplaceInputClass(): array
    {
        return [
            ['', []],
            ['', [null]],
            [' class', ['']],
            [' class="main"', ['main']],
            [' class="main bold"', ['main bold']],
            [' class="main bold"', ['main', 'bold']],
        ];
    }

    /**
     * @dataProvider dataReplaceInputClass
     *
     * @param string[] $class
     */
    public function testReplaceInputClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubInputField::widget()
            ->formAttribute(new TextForm(), 'company')
            ->inputClass('red')
            ->replaceInputClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="textform-company">Company</label>
            <input type="text" id="textform-company"$expectedClassAttribute name="TextForm[company]" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = StubInputField::widget();

        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->inputId(null));
        $this->assertNotSame($field, $field->setInputId(true));
        $this->assertNotSame($field, $field->inputAttributes([]));
        $this->assertNotSame($field, $field->addInputAttributes([]));
        $this->assertNotSame($field, $field->inputClass());
        $this->assertNotSame($field, $field->replaceInputClass());
    }
}
