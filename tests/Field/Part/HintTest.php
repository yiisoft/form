<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftYiiValidatableForm\FormModelInputData;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Tests\Support\Form\HintForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class HintTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->render();

        $this->assertSame('<div>Write your name.</div>', $result);
    }

    public function testAttributeWithoutHint(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'age'))
            ->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->tag('b')
            ->render();

        $this->assertSame('<b>Write your name.</b>', $result);
    }

    public function testEmptyTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()->tag('');
    }

    public function testAddAttributes(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->addAttributes(['class' => 'red'])
            ->addAttributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Write your name.</div>', $result);
    }

    public function testAttributes(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div data-number="18">Write your name.</div>', $result);
    }

    public function dataId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    /**
     * @dataProvider dataId
     */
    public function testId(string $expectedId, ?string $id): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->id($id)
            ->render();

        $expected = '<div' . $expectedId . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function dataAddClass(): array
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
     * @dataProvider dataAddClass
     *
     * @param string[] $class
     */
    public function testAddClass(string $expectedClassAttribute, array $class): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->addClass('main')
            ->addClass(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function dataAddNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataAddNewClass
     */
    public function testAddNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->addClass($class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function dataClass(): array
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
     * @dataProvider dataClass
     *
     * @param string[] $class
     */
    public function testClass(string $expectedClassAttribute, array $class): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->class('red')
            ->class(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function testCustomContent(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->content('Override hint.')
            ->render();

        $this->assertSame('<div>Override hint.</div>', $result);
    }

    public function testEmptyContent(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testEncode(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->content('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Hint::widget()
            ->inputData(new FormModelInputData(new HintForm(), 'name'))
            ->content('<b>your name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<div><b>your name</b></div>', $result);
    }

    public function testImmutability(): void
    {
        $widget = Hint::widget();
        $this->assertNotSame($widget, $widget->inputData(new PureInputData()));
        $this->assertNotSame($widget, $widget->tag('b'));
        $this->assertNotSame($widget, $widget->attributes([]));
        $this->assertNotSame($widget, $widget->addAttributes([]));
        $this->assertNotSame($widget, $widget->content(''));
        $this->assertNotSame($widget, $widget->encode(false));
    }
}
