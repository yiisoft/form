<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\ThemeContainer;

final class CheckboxTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public static function dataBase(): array
    {
        return [
            'base' => [
                <<<HTML
                <div>
                <input type="hidden" name="CheckboxForm[red]" value="0"><label><input type="checkbox" id="checkboxform-red" name="CheckboxForm[red]" value="1" checked> Red color</label>
                <div>If need red color.</div>
                </div>
                HTML,
                new PureInputData(
                    name: 'CheckboxForm[red]',
                    value: '1',
                    label: 'Red color',
                    hint: 'If need red color.',
                    id: 'checkboxform-red',
                ),
            ],
            'input-valid-class' => [
                <<<HTML
                <div>
                <input type="hidden" name="main" value="0"><input type="checkbox" class="valid" name="main" value="1" checked>
                </div>
                HTML,
                new PureInputData(name: 'main', value: '1', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="hidden" name="main" value="0"><input type="checkbox" name="main" value="1" checked>
                </div>
                HTML,
                new PureInputData(name: 'main', value: '1', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, PureInputData $inputData, array $theme = []): void
    {
        ThemeContainer::initialize(
            configs: ['default' => $theme],
            defaultConfig: 'default',
        );

        $result = Checkbox::widget()->inputData($inputData)->render();

        $this->assertSame($expected, $result);
    }

    public function testFalseValue(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()->inputData($inputData)->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputValue(): void
    {
        $inputData = new PureInputData('test-name', label: 'Red color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputValue('4')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="4"> Red color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCheckedInputValue(): void
    {
        $inputData = new PureInputData('test-name', 42, label: 'Your age 42?');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputValue('42')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="42" checked> Your age 42?</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataUncheckValue(): array
    {
        return [
            ['', null],
            ['<input type="hidden" name="test-name" value="7">', 7],
            ['<input type="hidden" name="test-name" value="7.42">', 7.42],
            ['<input type="hidden" name="test-name" value="hello">', 'hello'],
            ['<input type="hidden" name="test-name" value="1">', true],
            ['<input type="hidden" name="test-name" value="0">', false],
            ['<input type="hidden" name="test-name" value="x">', new StringableObject('x')],
        ];
    }

    #[DataProvider('dataUncheckValue')]
    public function testUncheckValue(string $expectedInput, mixed $uncheckValue): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->uncheckValue($uncheckValue)
            ->render();

        $expected = '<div>' . "\n" .
            $expectedInput .
            '<label><input type="checkbox" name="test-name" value="1"> Blue color</label>' . "\n" .
            '</div>';

        $this->assertSame($expected, $result);
    }

    public function testNotEnclosedByLabel(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->enclosedByLabel(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Blue color</label>
            <input type="hidden" name="test-name" value="0"><input type="checkbox" name="test-name" value="1">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAllLabels(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->label('Hello')
            ->inputLabel('Yes')
            ->hideLabel(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Hello</label>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="1"> Yes</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testWithoutInputLabel(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->label('Hello')
            ->hideLabel(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Hello</label>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="1"> Hello</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testBothLabelsWithNotEnclosedByLabel(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('Yes')
            ->enclosedByLabel(false)
            ->hideLabel(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Blue color</label>
            <input type="hidden" name="test-name" value="0"><input type="checkbox" name="test-name" value="1"> Yes
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputLabelEncode(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('A > B')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="1"> A &gt; B</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputLabelNotEncode(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('<b>Blue</b>')
            ->inputLabelEncode(false)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label><input type="checkbox" name="test-name" value="1"> <b>Blue</b></label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputLabelEncodeNotEnclosedByLabel(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('A > B')
            ->enclosedByLabel(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Blue color</label>
            <input type="hidden" name="test-name" value="0"><input type="checkbox" name="test-name" value="1"> A &gt; B
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputLabelNotEncodeNotEnclosedByLabel(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('<b>Blue</b>')
            ->inputLabelEncode(false)
            ->enclosedByLabel(false)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Blue color</label>
            <input type="hidden" name="test-name" value="0"><input type="checkbox" name="test-name" value="1"> <b>Blue</b>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddInputLabelAttributes(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->addInputLabelAttributes(['class' => 'red'])
            ->addInputLabelAttributes(['data-key' => 'x7'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label class="red" data-key="x7"><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInputLabelAttributes(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabelAttributes(['class' => 'red'])
            ->inputLabelAttributes(['data-key' => 'x7'])
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label data-key="x7"><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataInputLabelId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    #[DataProvider('dataInputLabelId')]
    public function testInputLabelId(string $expectedId, ?string $id): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabelId($id)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label$expectedId><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAddInputLabelClass(): array
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
    #[DataProvider('dataAddInputLabelClass')]
    public function testAddInputLabelClass(string $expectedClassAttribute, array $class): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->addInputLabelClass('main')
            ->addInputLabelClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label$expectedClassAttribute><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAddInputLabelNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    #[DataProvider('dataAddInputLabelNewClass')]
    public function testAddInputLabelNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->addInputLabelClass($class)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label$expectedClassAttribute><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataInputLabelClass(): array
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
    #[DataProvider('dataInputLabelClass')]
    public function testInputLabelClass(string $expectedClassAttribute, array $class): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabelClass('red')
            ->inputLabelClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="test-name" value="0"><label$expectedClassAttribute><input type="checkbox" name="test-name" value="1"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->disabled()
            ->uncheckValue(null)
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="checkbox" name="test-name" value="1" disabled> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescibedBy(): void
    {
        $result = Checkbox::widget()
            ->name('test-name')
            ->label('Blue color')
            ->ariaDescribedBy('hint')
            ->uncheckValue(null)
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="checkbox" name="test-name" value="1" aria-describedby="hint"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->ariaLabel('test')
            ->uncheckValue(null)
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="checkbox" name="test-name" value="1" aria-label="test"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->autofocus()
            ->uncheckValue(null)
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="checkbox" name="test-name" value="1" autofocus> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $inputData = new PureInputData('test-name', label: 'Blue color');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->tabIndex(2)
            ->uncheckValue(null)
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="checkbox" name="test-name" value="1" tabindex="2"> Blue color</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = Checkbox::widget()->value(new stdClass());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget requires a string, numeric, bool, Stringable or null value.');
        $field->render();
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new PureInputData('company', '');

        $result = Checkbox::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <input type="hidden" name="company" value="0"><input type="checkbox" class="invalid" name="company" value="1">
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $widget = Checkbox::widget();

        $this->assertNotSame($widget, $widget->uncheckValue(null));
        $this->assertNotSame($widget, $widget->enclosedByLabel(true));
        $this->assertNotSame($widget, $widget->inputLabel(null));
        $this->assertNotSame($widget, $widget->inputLabelAttributes([]));
        $this->assertNotSame($widget, $widget->addInputLabelAttributes([]));
        $this->assertNotSame($widget, $widget->inputLabelId(null));
        $this->assertNotSame($widget, $widget->addInputLabelClass());
        $this->assertNotSame($widget, $widget->inputLabelClass());
        $this->assertNotSame($widget, $widget->inputValue(null));
        $this->assertNotSame($widget, $widget->disabled());
        $this->assertNotSame($widget, $widget->ariaDescribedBy(null));
        $this->assertNotSame($widget, $widget->ariaLabel(null));
        $this->assertNotSame($widget, $widget->autofocus());
        $this->assertNotSame($widget, $widget->tabIndex(null));
        $this->assertNotSame($widget, $widget->inputLabelEncode(true));
    }
}
