<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Tests\Support\StubInputField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class InputFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testForm(): void
    {
        $result = StubInputField::widget()
            ->name('company')
            ->value('')
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" name="company" value form="CreatePost">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddInputAttributes(): void
    {
        $result = StubInputField::widget()
            ->addInputAttributes(['class' => 'red'])
            ->addInputAttributes(['id' => 'key'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" id="key" class="red" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testStringableInputId(): void
    {
        $result = StubInputField::widget()
            ->inputAttributes(['id' => new StringableObject('key')])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text" id="key" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAddInputClass(): array
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
     * @param string[] $class
     */
    #[DataProvider('dataAddInputClass')]
    public function testAddInputClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubInputField::widget()
            ->name('company')
            ->value('')
            ->addInputClass('main')
            ->addInputClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text"$expectedClassAttribute name="company" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAddInputNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    #[DataProvider('dataAddInputNewClass')]
    public function testAddInputNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = StubInputField::widget()
            ->name('company')
            ->value('')
            ->addInputClass($class)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text"$expectedClassAttribute name="company" value>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataInputClass(): array
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
     * @param string[] $class
     */
    #[DataProvider('dataInputClass')]
    public function testInputClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubInputField::widget()
            ->name('company')
            ->value('')
            ->inputClass('red')
            ->inputClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="text"$expectedClassAttribute name="company" value>
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
        $this->assertNotSame($field, $field->addInputClass());
        $this->assertNotSame($field, $field->inputClass());
        $this->assertNotSame($field, $field->inputData(new PureInputData()));
        $this->assertNotSame($field, $field->name(null));
        $this->assertNotSame($field, $field->value(null));
    }
}
