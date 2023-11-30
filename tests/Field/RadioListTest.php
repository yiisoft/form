<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;
use Yiisoft\Form\Field\RadioList;
use Yiisoft\Form\Tests\Support\Form\RadioListForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RadioListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = RadioList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->inputData(new FormModelInputData(new RadioListForm(), 'color'))
            ->render();

        $expected = <<<'HTML'
            <div>
            <label>Select color</label>
            <div>
            <label><input type="radio" name="RadioListForm[color]" value="red"> Red</label>
            <label><input type="radio" name="RadioListForm[color]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testRadioAttributes(): void
    {
        $result = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
            ->items([1 => 'One', 2 => 'Two'])
            ->useContainer(false)
            ->hideLabel()
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

    public function testAddRadioAttributes(): void
    {
        $result = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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

    public function testRadioAttributesReplace(): void
    {
        $result = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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

    public function dataItemsFromValues(): array
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

    /**
     * @dataProvider dataItemsFromValues
     */
    public function testItemsFromValues(string $expected, array $values): void
    {
        $result = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
            ->useContainer(false)
            ->hideLabel()
            ->itemsFromValues($values)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testItemsFromValuesWithoutEncodeLabel(): void
    {
        $result = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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

    public function dataUncheckValue(): array
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

    /**
     * @dataProvider dataUncheckValue
     */
    public function testUncheckValue(string $expected, $value): void
    {
        $result = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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
            ->inputData(new FormModelInputData(new RadioListForm(), 'number'))
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

    public function testInvalidValue(): void
    {
        $field = RadioList::widget()
            ->inputData(new FormModelInputData(new RadioListForm(), 'data'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"RadioList" field requires a string, numeric, bool, Stringable or null value.');
        $field->render();
    }

    public function testImmutability(): void
    {
        $field = RadioList::widget();

        $this->assertNotSame($field, $field->radioAttributes([]));
        $this->assertNotSame($field, $field->addRadioAttributes([]));
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
