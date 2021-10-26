<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldRangeTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    public function testMax(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'int')->range(['max' => 8])->render(),
        );
    }

    public function testMin(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" min="4" oninput="i2.value=this.value">
        <output id="i2" name="i2" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'int')->range(['min' => 4])->render(),
        );
    }

    public function testOutputAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" outputAttributes='{"class":"test-class"}' oninput="i3.value=this.value">
        <output id="i3" class="test-class" name="i3" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'int')
                ->range(['outputAttributes' => ['class' => 'test-class']])
                ->render(),
        );
    }

    public function testOutputTag(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" outputTag="p" oninput="i4.value=this.value">
        <p id="i4" name="i4" for="TypeForm[int]">0</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'int')
                ->range(['outputTag' => 'p'])
                ->render(),
        );
    }

    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Field::widget()->config($this->formModel, 'int')->range(['outputTag' => ''])->render();
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i6.value=this.value">
        <output id="i6" name="i6" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'int')->range()->render(),
        );
    }

    public function testValue(): void
    {
        // string value numeric `1`.
        $this->formModel->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="range" id="typeform-string" name="TypeForm[string]" value="1" placeholder="Typed your text string." oninput="i7.value=this.value">
        <output id="i7" name="i7" for="TypeForm[string]">1</output>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'string')->range()->render(),
        );

        // int value 1
        $this->formModel->setAttribute('int', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="1" oninput="i8.value=this.value">
        <output id="i8" name="i8" for="TypeForm[int]">1</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'int')->range()->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric value.');
        Field::widget()->config($this->formModel, 'array')->range()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
