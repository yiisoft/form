<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\CheckboxLabelPlacement;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Theme\ThemeContainer;

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
                new InputData(
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
                new InputData(name: 'main', value: '1', validationErrors: []),
                ['inputValidClass' => 'valid', 'inputInvalidClass' => 'invalid'],
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <input type="hidden" name="main" value="0"><input type="checkbox" name="main" value="1" checked>
                </div>
                HTML,
                new InputData(name: 'main', value: '1', validationErrors: []),
                ['validClass' => 'valid', 'invalidClass' => 'invalid'],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expected, InputData $inputData, array $theme = []): void
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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Red color');

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
        $inputData = new InputData('test-name', 42, label: 'Your age 42?');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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

    public static function dataAriaDescribedBy(): array
    {
        return [
            'one element' => [
                ['hint'],
                <<<HTML
                <div>
                <label><input type="checkbox" name="test-name" value="1" aria-describedby="hint"> Blue color</label>
                </div>
                HTML,
            ],
            'multiple elements' => [
                ['hint1', 'hint2'],
                <<<HTML
                <div>
                <label><input type="checkbox" name="test-name" value="1" aria-describedby="hint1 hint2"> Blue color</label>
                </div>
                HTML,
            ],
            'null with other elements' => [
                ['hint1', null, 'hint2', null, 'hint3'],
                <<<HTML
                <div>
                <label><input type="checkbox" name="test-name" value="1" aria-describedby="hint1 hint2 hint3"> Blue color</label>
                </div>
                HTML,
            ],
            'only null' => [
                [null, null],
                <<<HTML
                <div>
                <label><input type="checkbox" name="test-name" value="1"> Blue color</label>
                </div>
                HTML,
            ],
            'empty string' => [
                [''],
                <<<HTML
                <div>
                <label><input type="checkbox" name="test-name" value="1" aria-describedby> Blue color</label>
                </div>
                HTML,
            ],
        ];
    }

    #[DataProvider('dataAriaDescribedBy')]
    public function testAriaDescribedBy(array $ariaDescribedBy, string $expectedHtml): void
    {
        $actualHtml = Checkbox::widget()
            ->name('test-name')
            ->label('Blue color')
            ->ariaDescribedBy(...$ariaDescribedBy)
            ->uncheckValue(null)
            ->render();
        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testAriaLabel(): void
    {
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $inputData = new InputData('test-name', label: 'Blue color');

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
        $this->expectExceptionMessage('Checkbox widget requires a string, Stringable, numeric, bool or null value.');
        $field->render();
    }

    public function testStringableValue(): void
    {
        $actualHtml = Checkbox::widget()
            ->inputValue('value')
            ->value(new StringableObject('value'))
            ->render();
        $expectedHtml = <<<HTML
        <div>
        <input type="checkbox" value="value" checked>
        </div>
        HTML;

        $this->assertSame($expectedHtml, $actualHtml);
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', '');

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

    public static function dataLabelPlacement(): iterable
    {
        yield 'default' => [
            <<<HTML
            <div>
            <label for="UID">Voronezh</label>
            <input type="checkbox" id="UID" name="city" value="1">
            </div>
            HTML,
            CheckboxLabelPlacement::DEFAULT,
        ];
        yield 'wrap' => [
            <<<HTML
            <div>
            <label><input type="checkbox" id="UID" name="city" value="1"> Voronezh</label>
            </div>
            HTML,
            CheckboxLabelPlacement::WRAP,
        ];
        yield 'side' => [
            <<<HTML
            <div>
            <input type="checkbox" id="UID" name="city" value="1"> <label for="UID">Voronezh</label>
            </div>
            HTML,
            CheckboxLabelPlacement::SIDE,
        ];
    }

    #[DataProvider('dataLabelPlacement')]
    public function testLabelPlacement(string $expected, CheckboxLabelPlacement $placement): void
    {
        $inputData = new InputData('city', label: 'Voronezh');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputId('UID')
            ->uncheckValue(null)
            ->labelPlacement($placement)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataLabelPlacementWithInputLabel(): iterable
    {
        yield 'default' => [
            <<<HTML
            <div>
            <label for="UID">Voronezh</label>
            <input type="checkbox" id="UID" name="city" value="1"> Moscow
            </div>
            HTML,
            CheckboxLabelPlacement::DEFAULT,
        ];
        yield 'wrap' => [
            <<<HTML
            <div>
            <label><input type="checkbox" id="UID" name="city" value="1"> Moscow</label>
            </div>
            HTML,
            CheckboxLabelPlacement::WRAP,
        ];
        yield 'side' => [
            <<<HTML
            <div>
            <input type="checkbox" id="UID" name="city" value="1"> <label for="UID">Moscow</label>
            </div>
            HTML,
            CheckboxLabelPlacement::SIDE,
        ];
    }

    #[DataProvider('dataLabelPlacementWithInputLabel')]
    public function testLabelPlacementWithInputLabel(string $expected, CheckboxLabelPlacement $placement): void
    {
        $inputData = new InputData('city', label: 'Voronezh');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('Moscow')
            ->inputId('UID')
            ->uncheckValue(null)
            ->labelPlacement($placement)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataLabelPlacementWithLabel(): iterable
    {
        yield 'default' => [
            <<<HTML
            <div>
            <label for="UID">Moscow</label>
            <input type="checkbox" id="UID" name="city" value="1">
            </div>
            HTML,
            CheckboxLabelPlacement::DEFAULT,
        ];
        yield 'wrap' => [
            <<<HTML
            <div>
            <label><input type="checkbox" id="UID" name="city" value="1"> Moscow</label>
            </div>
            HTML,
            CheckboxLabelPlacement::WRAP,
        ];
        yield 'side' => [
            <<<HTML
            <div>
            <input type="checkbox" id="UID" name="city" value="1"> <label for="UID">Moscow</label>
            </div>
            HTML,
            CheckboxLabelPlacement::SIDE,
        ];
    }

    #[DataProvider('dataLabelPlacementWithLabel')]
    public function testLabelPlacementWithLabel(string $expected, CheckboxLabelPlacement $placement): void
    {
        $inputData = new InputData('city', label: 'Voronezh');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->label('Moscow')
            ->inputId('UID')
            ->uncheckValue(null)
            ->labelPlacement($placement)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataLabelPlacementWithLabelAndInputLabel(): iterable
    {
        yield 'default' => [
            <<<HTML
            <div>
            <label for="UID">Vladivostok</label>
            <input type="checkbox" id="UID" name="city" value="1"> Moscow
            </div>
            HTML,
            CheckboxLabelPlacement::DEFAULT,
        ];
        yield 'wrap' => [
            <<<HTML
            <div>
            <label><input type="checkbox" id="UID" name="city" value="1"> Moscow</label>
            </div>
            HTML,
            CheckboxLabelPlacement::WRAP,
        ];
        yield 'side' => [
            <<<HTML
            <div>
            <input type="checkbox" id="UID" name="city" value="1"> <label for="UID">Moscow</label>
            </div>
            HTML,
            CheckboxLabelPlacement::SIDE,
        ];
    }

    #[DataProvider('dataLabelPlacementWithLabelAndInputLabel')]
    public function testLabelPlacementWithLabelAndInputLabel(string $expected, CheckboxLabelPlacement $placement): void
    {
        $inputData = new InputData('city', label: 'Voronezh');

        $result = Checkbox::widget()
            ->inputData($inputData)
            ->inputLabel('Moscow')
            ->label('Vladivostok')
            ->inputId('UID')
            ->uncheckValue(null)
            ->labelPlacement($placement)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $widget = Checkbox::widget();

        $this->assertNotSame($widget, $widget->uncheckValue(null));
        $this->assertNotSame($widget, $widget->enclosedByLabel(true));
        $this->assertNotSame($widget, $widget->labelPlacement(CheckboxLabelPlacement::DEFAULT));
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
