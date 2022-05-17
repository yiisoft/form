<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Tests\Support\Form\HintForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class HintTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->render();

        $this->assertSame('<div>Write your name.</div>', $result);
    }

    public function testAttributeWithoutHint(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'age')
            ->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->tag('b')
            ->render();

        $this->assertSame('<b>Write your name.</b>', $result);
    }

    public function testEmptyTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->tag('');
    }

    public function testAttributes(): void
    {
        $result = Hint::widget()
             ->formAttribute(new HintForm(), 'name')
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Write your name.</div>', $result);
    }

    public function testReplaceAttributes(): void
    {
        $result = Hint::widget()
             ->formAttribute(new HintForm(), 'name')
            ->attributes(['class' => 'red'])
            ->replaceAttributes(['data-number' => 18])
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
             ->formAttribute(new HintForm(), 'name')
            ->id($id)
            ->render();

        $expected = '<div' . $expectedId . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function dataClass(): array
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
     * @dataProvider dataClass
     *
     * @param string[] $class
     */
    public function testClass(string $expectedClassAttribute, array $class): void
    {
        $result = Hint::widget()
             ->formAttribute(new HintForm(), 'name')
            ->class('main')
            ->class(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function dataNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataNewClass
     */
    public function testNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = Hint::widget()
             ->formAttribute(new HintForm(), 'name')
            ->class($class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function dataReplaceClass(): array
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
     * @dataProvider dataReplaceClass
     *
     * @param string[] $class
     */
    public function testReplaceClass(string $expectedClassAttribute, array $class): void
    {
        $result = Hint::widget()
             ->formAttribute(new HintForm(), 'name')
            ->class('red')
            ->replaceClass(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Write your name.</div>';

        $this->assertSame($expected, $result);
    }

    public function testCustomContent(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->content('Override hint.')
            ->render();

        $this->assertSame('<div>Override hint.</div>', $result);
    }

    public function testEmptyContent(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testEncode(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->content('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Hint::widget()
            ->formAttribute(new HintForm(), 'name')
            ->content('<b>your name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<div><b>your name</b></div>', $result);
    }

    public function testWithoutAttribute(): void
    {
        $widget = Hint::widget();
        $this->assertSame('', $widget->render());
    }

    public function testImmutability(): void
    {
        $widget = Hint::widget();
        $this->assertNotSame($widget, $widget->formAttribute(new HintForm(), 'name'));
        $this->assertNotSame($widget, $widget->tag('b'));
        $this->assertNotSame($widget, $widget->attributes([]));
        $this->assertNotSame($widget, $widget->content(''));
        $this->assertNotSame($widget, $widget->encode(false));
    }
}
