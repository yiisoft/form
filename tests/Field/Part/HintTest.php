<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Part\Hint;
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
        $inputData = new PureInputData(hint: 'Write your name.');

        $result = Hint::widget()->inputData($inputData)->render();

        $this->assertSame('<div>Write your name.</div>', $result);
    }

    public function testEmpty(): void
    {
        $result = Hint::widget()->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $result = Hint::widget()
            ->content('Write your name.')
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
            ->content('Write your name.')
            ->addAttributes(['class' => 'red'])
            ->addAttributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Write your name.</div>', $result);
    }

    public function testAttributes(): void
    {
        $result = Hint::widget()
            ->content('Write your name.')
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div data-number="18">Write your name.</div>', $result);
    }

    public static function dataId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

     #[DataProvider('dataId')]
    public function testId(string $expectedId, ?string $id): void
    {
        $result = Hint::widget()
            ->content('Write your name.')
            ->id($id)
            ->render();

        $expected = '<div' . $expectedId . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public static function dataAddClass(): array
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
    #[DataProvider('dataAddClass')]
    public function testAddClass(string $expectedClassAttribute, array $class): void
    {
        $result = Hint::widget()
            ->content('Write your name.')
            ->addClass('main')
            ->addClass(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public static function dataAddNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

     #[DataProvider('dataAddNewClass')]
    public function testAddNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = Hint::widget()
            ->content('Write your name.')
            ->addClass($class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public static function dataClass(): array
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
    #[DataProvider('dataClass')]
    public function testClass(string $expectedClassAttribute, array $class): void
    {
        $result = Hint::widget()
            ->content('Write your name.')
            ->class('red')
            ->class(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function testCustomContent(): void
    {
        $inputData = new PureInputData(hint: 'Write your name.');

        $result = Hint::widget()
            ->inputData($inputData)
            ->content('Override hint.')
            ->render();

        $this->assertSame('<div>Override hint.</div>', $result);
    }

    public function testEmptyContent(): void
    {
        $inputData = new PureInputData(hint: 'Write your name.');

        $result = Hint::widget()
            ->inputData($inputData)
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testEncode(): void
    {
        $inputData = new PureInputData(hint: 'Write your name.');

        $result = Hint::widget()
            ->inputData($inputData)
            ->content('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $inputData = new PureInputData(hint: 'Write your name.');

        $result = Hint::widget()
            ->inputData($inputData)
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
