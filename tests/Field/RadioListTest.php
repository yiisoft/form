<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\RadioList;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Html\Widget\RadioList\RadioItem;

final class RadioListTest extends TestCase
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
                <label>Select color</label>
                <div>
                <label><input type="radio" name="RadioListForm[color]" value="red"> Red</label>
                <label><input type="radio" name="RadioListForm[color]" value="blue"> Blue</label>
                </div>
                <div>Color of box.</div>
                </div>
                HTML,
                new PureInputData(
                    name: 'RadioListForm[color]',
                    label: 'Select color',
                    hint: 'Color of box.',
                    id: 'UID',
                ),
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <div>
                <label><input type="radio" name="color" value="red"> Red</label>
                <label><input type="radio" name="color" value="blue"> Blue</label>
                </div>
                </div>
                HTML,
                new PureInputData(name: 'color', validationErrors: []),
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

        $result = RadioList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->inputData($inputData)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testRadioAttributes(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two'])
            ->value(2)
            ->useContainer(false)
            ->hideLabel()
            ->radioAttributes(['class' => 'red'])
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="2" checked> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddRadioAttributes(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two'])
            ->useContainer(false)
            ->hideLabel()
            ->addRadioAttributes(['readonly' => true])
            ->addRadioAttributes(['class' => 'red'])
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="1" readonly> One</label>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="2" readonly> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddRadioLabelAttributes(): void
    {
        $result = RadioList::widget()
            ->itemsFromValues(['Red', 'Blue'])
            ->name('RadioListForm[color]')
            ->addRadioLabelAttributes(['class' => 'control'])
            ->addRadioLabelAttributes(['data-key' => 'x100'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label class="control" data-key="x100"><input type="radio" name="RadioListForm[color]" value="Red"> Red</label>
            <label class="control" data-key="x100"><input type="radio" name="RadioListForm[color]" value="Blue"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRadioLabelAttributes(): void
    {
        $result = RadioList::widget()
            ->itemsFromValues(['Red', 'Blue'])
            ->name('RadioListForm[color]')
            ->radioLabelAttributes(['data-key' => 'x100'])
            ->radioLabelAttributes(['class' => 'control'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label class="control"><input type="radio" name="RadioListForm[color]" value="Red"> Red</label>
            <label class="control"><input type="radio" name="RadioListForm[color]" value="Blue"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRadioAttributesReplace(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two'])
            ->useContainer(false)
            ->hideLabel()
            ->radioAttributes(['readonly' => true])
            ->radioAttributes(['class' => 'red'])
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="2"> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddIndividualInputAttributes(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two', 3 => 'Three'])
            ->useContainer(false)
            ->hideLabel()
            ->radioAttributes(['class' => 'red'])
            ->addIndividualInputAttributes([
                2 => ['class' => 'blue'],
                3 => ['class' => 'green'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" class="blue" name="RadioListForm[number]" value="2"> Two</label>
            <label><input type="radio" class="green" name="RadioListForm[number]" value="3"> Three</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testIndividualUncheckInputAttributes(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two'])
            ->useContainer(false)
            ->hideLabel()
            ->radioAttributes(['class' => 'red'])
            ->individualInputAttributes([
                0 => ['class' => 'blue'],
            ])
            ->uncheckValue(0)
            ->render();

        $expected = <<<HTML
            <input type="hidden" class="blue" name="RadioListForm[number]" value="0">
            <div>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="2"> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddIndividualInputAttributesMerge(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two', 3 => 'Three'])
            ->useContainer(false)
            ->hideLabel()
            ->radioAttributes(['class' => 'red'])
            ->addIndividualInputAttributes([
                2 => ['class' => 'blue'],
                3 => ['class' => 'green'],
            ])
            ->addIndividualInputAttributes([
                1 => ['class' => 'yellow'],
                2 => ['class' => 'cyan'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" class="yellow" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" class="cyan" name="RadioListForm[number]" value="2"> Two</label>
            <label><input type="radio" class="green" name="RadioListForm[number]" value="3"> Three</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testIndividualInputAttributesReplace(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => 'Two', 3 => 'Three'])
            ->useContainer(false)
            ->hideLabel()
            ->radioAttributes(['class' => 'red'])
            ->individualInputAttributes([
                2 => ['class' => 'blue'],
                3 => ['class' => 'green'],
            ])
            ->individualInputAttributes([
                1 => ['class' => 'yellow'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" class="yellow" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="2"> Two</label>
            <label><input type="radio" class="red" name="RadioListForm[number]" value="3"> Three</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItems(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => '<b>Two</b>'])
            ->useContainer(false)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="2"> &lt;b&gt;Two&lt;/b&gt;</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItemsWithoutEncodeLabel(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->items([1 => 'One', 2 => '<b>Two</b>'], false)
            ->useContainer(false)
            ->hideLabel()
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="2"> <b>Two</b></label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataItemsFromValues(): array
    {
        return [
            [
                <<<HTML
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="1"> 1</label>
                <label><input type="radio" name="RadioListForm[number]" value="2"> 2</label>
                </div>
                HTML,
                [1, 2],
            ],
            [
                <<<HTML
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="One"> One</label>
                <label><input type="radio" name="RadioListForm[number]" value="&lt;b&gt;Two&lt;/b&gt;"> &lt;b&gt;Two&lt;/b&gt;</label>
                </div>
                HTML,
                ['One', '<b>Two</b>'],
            ],
            [
                <<<HTML
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="1"> 1</label>
                <label><input type="radio" name="RadioListForm[number]" value></label>
                </div>
                HTML,
                [true, false],
            ],
        ];
    }

    #[DataProvider('dataItemsFromValues')]
    public function testItemsFromValues(string $expected, array $values): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->itemsFromValues($values)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testItemsFromValuesWithoutEncodeLabel(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->itemsFromValues([
                'One',
                '<b>Two</b>',
            ], false)
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="One"> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="&lt;b&gt;Two&lt;/b&gt;"> <b>Two</b></label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataUncheckValue(): array
    {
        return [
            [
                <<<HTML
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
                <label><input type="radio" name="RadioListForm[number]" value="2"> Two</label>
                </div>
                HTML,
                null,
            ],
            [
                <<<HTML
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
                <label><input type="radio" name="RadioListForm[number]" value="2"> Two</label>
                </div>
                HTML,
                null,
            ],
            [
                <<<HTML
                <input type="hidden" name="RadioListForm[number]" value="7">
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
                <label><input type="radio" name="RadioListForm[number]" value="2"> Two</label>
                </div>
                HTML,
                7,
            ],
            [
                <<<HTML
                <input type="hidden" name="RadioListForm[number]" value="7">
                <div>
                <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
                <label><input type="radio" name="RadioListForm[number]" value="2"> Two</label>
                </div>
                HTML,
                7,
            ],
        ];
    }

    #[DataProvider('dataUncheckValue')]
    public function testUncheckValue(string $expected, $value): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->uncheckValue($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testUncheckValueDisabled(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->uncheckValue(7)
            ->disabled()
            ->render();

        $expected = <<<HTML
            <input type="hidden" name="RadioListForm[number]" value="7" disabled>
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1" disabled> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="2" disabled> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckValueForm(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->uncheckValue(7)
            ->form('post')
            ->render();

        $expected = <<<HTML
            <input type="hidden" name="RadioListForm[number]" value="7" form="post">
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1" form="post"> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="2" form="post"> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSeparator(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->separator("\n<br>\n")
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1"> One</label>
            <br>
            <label><input type="radio" name="RadioListForm[number]" value="2"> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItemFormatter(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->itemFormatter(
                static fn (RadioItem $item): string => '<div>' .
                    $item->index . ') ' .
                    Html::radio($item->radioAttributes['name'], $item->radioAttributes['value'])
                        ->attributes($item->radioAttributes)
                        ->checked($item->checked)
                        ->label($item->label) .
                    '</div>'
            )
            ->render();

        $expected = <<<HTML
            <div>
            <div>0) <label><input type="radio" name="RadioListForm[number]" value="1"> One</label></div>
            <div>1) <label><input type="radio" name="RadioListForm[number]" value="2"> Two</label></div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testForm(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->form('post')
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1" form="post"> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="2" form="post"> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = RadioList::widget()
            ->name('RadioListForm[number]')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="RadioListForm[number]" value="1" disabled> One</label>
            <label><input type="radio" name="RadioListForm[number]" value="2" disabled> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testWithStringableValue(): void
    {
        $result = RadioList::widget()
            ->name('number')
            ->useContainer(false)
            ->hideLabel()
            ->items([1 => 'One', 2 => 'Two'])
            ->value(new StringableObject('2'))
            ->render();

        $expected = <<<HTML
            <div>
            <label><input type="radio" name="number" value="1"> One</label>
            <label><input type="radio" name="number" value="2" checked> Two</label>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = RadioList::widget()->name('test')->value([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"RadioList" field requires a string, numeric, bool, Stringable or null value.');
        $field->render();
    }

    public function testWithoutName(): void
    {
        $field = RadioList::widget();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('"RadioList" field requires non-empty name.');
        $field->render();
    }

    public function testEmptyName(): void
    {
        $field = RadioList::widget()->name('');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('"RadioList" field requires non-empty name.');
        $field->render();
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new PureInputData('number', 2);

        $result = RadioList::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->items([1 => 'One', 2 => 'Two'])
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <div>
            <label><input type="radio" class="invalid" name="number" value="1"> One</label>
            <label><input type="radio" class="invalid" name="number" value="2" checked> Two</label>
            </div>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = RadioList::widget();

        $this->assertNotSame($field, $field->radioAttributes([]));
        $this->assertNotSame($field, $field->addRadioAttributes([]));
        $this->assertNotSame($field, $field->addRadioLabelAttributes([]));
        $this->assertNotSame($field, $field->radioLabelAttributes([]));
        $this->assertNotSame($field, $field->individualInputAttributes([]));
        $this->assertNotSame($field, $field->addIndividualInputAttributes([]));
        $this->assertNotSame($field, $field->items([]));
        $this->assertNotSame($field, $field->itemsFromValues([]));
        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->uncheckValue(null));
        $this->assertNotSame($field, $field->separator(''));
        $this->assertNotSame($field, $field->itemFormatter(null));
    }
}
