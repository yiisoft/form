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
            ->attribute(new HintForm(), 'name')
            ->render();

        $this->assertSame('<div>Write your name.</div>', $result);
    }

    public function testAttributeWithoutHint(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'age')
            ->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'name')
            ->tag('b')
            ->render();

        $this->assertSame('<b>Write your name.</b>', $result);
    }

    public function testEmptyTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()
            ->attribute(new HintForm(), 'name')
            ->tag('');
    }

    public function testTagAttributes(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'name')
            ->tagAttributes(['class' => 'red', 'data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Write your name.</div>', $result);
    }

    public function testCustomContent(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'name')
            ->content('Override hint.')
            ->render();

        $this->assertSame('<div>Override hint.</div>', $result);
    }

    public function testEmptyContent(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'name')
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testEncode(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'name')
            ->content('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Hint::widget()
            ->attribute(new HintForm(), 'name')
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
        $this->assertNotSame($widget, $widget->attribute(new HintForm(), 'name'));
        $this->assertNotSame($widget, $widget->tag('b'));
        $this->assertNotSame($widget, $widget->tagAttributes([]));
        $this->assertNotSame($widget, $widget->content(''));
        $this->assertNotSame($widget, $widget->encode(false));
    }
}
