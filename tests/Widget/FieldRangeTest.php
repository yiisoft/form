<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Html;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldRangeTest extends TestCase
{
    use TestTrait;

    public function testMax(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->range([], ['max' => 8])->render(),
        );
    }

    public function testMin(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 1]);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" min="4" oninput="i2.value=this.value">
        <output id="i2" name="i2" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->range([], ['min' => 4])->render(),
        );
    }

    public function testOutputAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 2]);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i3.value=this.value">
        <output id="i3" class="test-class" name="i3" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->range(['outputAttributes()' => [['class' => 'test-class']]])
                ->render(),
        );
    }

    public function testOutputTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 3]);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i4.value=this.value">
        <p id="i4" name="i4" for="TypeForm[int]">0</p>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->range(['outputTag()' => ['p']])->render(),
        );
    }

    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Field::widget()->for($this->formModel, 'int')->range(['outputTag()' => ['']])->render();
    }

    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 5]);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i6.value=this.value">
        <output id="i6" name="i6" for="TypeForm[int]">0</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->for($this->formModel, 'int')->range()->render());
    }

    public function testValue(): void
    {
        // value null
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 6]);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-tonull">To Null</label>
        <input type="range" id="typeform-tonull" name="TypeForm[toNull]" oninput="i7.value=this.value">
        <output id="i7" name="i7" for="TypeForm[toNull]"></output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->for($this->formModel, 'toNull')->range()->render());

        // value string numeric `1`
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 7]);
        $this->formModel->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="range" id="typeform-string" name="TypeForm[string]" value="1" placeholder="Typed your text string." oninput="i8.value=this.value">
        <output id="i8" name="i8" for="TypeForm[string]">1</output>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->for($this->formModel, 'string')->range()->render());

        // value int 1
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', ['i' => 8]);
        $this->formModel->setAttribute('int', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="range" id="typeform-int" name="TypeForm[int]" value="1" oninput="i9.value=this.value">
        <output id="i9" name="i9" for="TypeForm[int]">1</output>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->for($this->formModel, 'int')->range()->render());
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric or null value.');
        Field::widget()->for($this->formModel, 'array')->range()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
