<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\CheckboxForm;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'red')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[red]" value="0"><label><input type="checkbox" id="checkboxform-red" name="CheckboxForm[red]" value="1" checked> Red color</label>
        <div>If need red color.</div>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testFalseValue(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Blue color</label>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputValue(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'red')
            ->inputValue('4')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[red]" value="0"><label><input type="checkbox" id="checkboxform-red" name="CheckboxForm[red]" value="4"> Red color</label>
        <div>If need red color.</div>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testCheckedInputValue(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'age')
            ->inputValue('42')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[age]" value="0"><label><input type="checkbox" id="checkboxform-age" name="CheckboxForm[age]" value="42" checked> Your age 42?</label>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function dataUncheckValue(): array
    {
        return [
            ['', null],
            ['<input type="hidden" name="CheckboxForm[blue]" value="7">', 7],
            ['<input type="hidden" name="CheckboxForm[blue]" value="7.42">', 7.42],
            ['<input type="hidden" name="CheckboxForm[blue]" value="hello">', 'hello'],
            ['<input type="hidden" name="CheckboxForm[blue]" value="1">', true],
            ['<input type="hidden" name="CheckboxForm[blue]" value="0">', false],
            ['<input type="hidden" name="CheckboxForm[blue]" value="x">', new StringableObject('x')],
        ];
    }

    /**
     * @dataProvider dataUncheckValue
     */
    public function testUncheckValue(string $expectedInput, mixed $uncheckValue): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->uncheckValue($uncheckValue)
            ->render();

        $expected = '<div>' . "\n" .
            $expectedInput .
            '<label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Blue color</label>' . "\n" .
            '</div>';

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testNotEnclosedByLabel(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->enclosedByLabel(false)
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="checkboxform-blue">Blue color</label>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1">
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testBothLabels(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabel('Yes')
            ->hideLabel(false)
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="checkboxform-blue">Blue color</label>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Yes</label>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testBothLabelsWithNotEnclosedByLabel(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabel('Yes')
            ->enclosedByLabel(false)
            ->hideLabel(false)
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="checkboxform-blue">Blue color</label>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Yes
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputLabelEncode(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabel('A > B')
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> A &gt; B</label>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputLabelNotEncode(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabel('<b>Blue</b>')
            ->inputLabelEncode(false)
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> <b>Blue</b></label>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputLabelEncodeNotEnclosedByLabel(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabel('A > B')
            ->enclosedByLabel(false)
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="checkboxform-blue">Blue color</label>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> A &gt; B
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputLabelNotEncodeNotEnclosedByLabel(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabel('<b>Blue</b>')
            ->inputLabelEncode(false)
            ->enclosedByLabel(false)
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="checkboxform-blue">Blue color</label>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> <b>Blue</b>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testInputLabelAttributes(): void
    {
        $result = Checkbox::widget()
            ->attribute(new CheckboxForm(), 'blue')
            ->inputLabelAttributes(['class' => 'red'])
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="hidden" name="CheckboxForm[blue]" value="0"><label class="red"><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Blue color</label>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testImmutability(): void
    {
        $widget = Checkbox::widget();

        $this->assertNotSame($widget, $widget->uncheckValue(null));
        $this->assertNotSame($widget, $widget->enclosedByLabel(true));
        $this->assertNotSame($widget, $widget->inputLabel(null));
        $this->assertNotSame($widget, $widget->inputLabelAttributes([]));
        $this->assertNotSame($widget, $widget->inputValue(null));
    }
}
