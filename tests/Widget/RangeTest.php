<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Range;
use Yiisoft\Html\Html;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RangeTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    public function testImmutability(): void
    {
        $range = Range::widget();
        $this->assertNotSame($range, $range->max(0));
        $this->assertNotSame($range, $range->min(0));
    }

    public function testMax(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'int')->max(8)->render(),
        );
    }

    public function testMin(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 1]);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" min="4" oninput="i2.value=this.value">
        <output id="i2" name="i2" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'int')->min(4)->render(),
        );
    }

    public function testOutputAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 2]);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i3.value=this.value">
        <output id="i3" class="test-class" name="i3" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'int')->outputAttributes(['class' => 'test-class'])->render(),
        );
    }

    public function testOutputTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 3]);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i4.value=this.value">
        <p id="i4" name="i4" for="TypeForm[int]">0</p>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'int')->outputTag('p')->render(),
        );
    }

    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Range::widget()->config($this->formModel, 'int')->outputTag('')->render();
    }

    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 5]);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i6.value=this.value">
        <output id="i6" name="i6" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'int')->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 6]);
        $expected = <<<'HTML'
        <input type="range" id="typeform-tonull" name="TypeForm[toNull]" oninput="i7.value=this.value">
        <output id="i7" name="i7" for="TypeForm[toNull]"></output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'toNull')->render(),
        );

        // value string numeric `1`
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 7]);
        $this->formModel->setAttribute('string', '1');
        $expected = <<<'HTML'
        <input type="range" id="typeform-string" name="TypeForm[string]" value="1" oninput="i8.value=this.value">
        <output id="i8" name="i8" for="TypeForm[string]">1</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'string')->render(),
        );

        // value int 1
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 8]);
        $this->formModel->setAttribute('int', '1');
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="1" oninput="i9.value=this.value">
        <output id="i9" name="i9" for="TypeForm[int]">1</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->config($this->formModel, 'int')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric or null value.');
        Range::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
