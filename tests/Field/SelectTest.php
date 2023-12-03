<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Select;
use Yiisoft\Form\Tests\Support\StubValidationRulesEnricher;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class SelectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData(
            name: 'SelectForm[number]',
            label: 'Select number',
            id: 'selectform-number',
        );

        $result = Select::widget()
            ->inputData($inputData)
            ->optionsData([
                1 => 'One',
                2 => 'Two',
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label for="selectform-number">Select number</label>
            <select id="selectform-number" name="SelectForm[number]">
            <option value="1">One</option>
            <option value="2">Two</option>
            </select>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSelectedSingle(): void
    {
        $result = Select::widget()
            ->name('count')
            ->value('15')
            ->optionsData([
                10 => 'Ten',
                15 => 'Fifteen',
                20 => 'Twenty',
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <select name="count">
            <option value="10">Ten</option>
            <option value="15" selected>Fifteen</option>
            <option value="20">Twenty</option>
            </select>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSelectedMultiple(): void
    {
        $inputData = new PureInputData(
            name: 'SelectForm[letters]',
            value: ['A', 'C'],
            label: 'Select letters',
            id: 'selectform-letters',
        );

        $result = Select::widget()
            ->inputData($inputData)
            ->optionsData([
                'A' => 'Letter A',
                'B' => 'Letter B',
                'C' => 'Letter C',
            ])
            ->multiple()
            ->render();

        $expected = <<<HTML
            <div>
            <label for="selectform-letters">Select letters</label>
            <input type="hidden" name="SelectForm[letters]" value>
            <select id="selectform-letters" name="SelectForm[letters][]" multiple>
            <option value="A" selected>Letter A</option>
            <option value="B">Letter B</option>
            <option value="C" selected>Letter C</option>
            </select>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataItems(): array
    {
        return [
            [
                '<select name="item"></select>',
                [],
            ],
            [
                <<<HTML
                <select name="item">
                <option value="1">One</option>
                <option value="2">Two</option>
                </select>
                HTML,
                [
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Option::tag()
                        ->value('2')
                        ->content('Two'),
                ],
            ],
            [
                <<<HTML
                <select name="item">
                <option value="1">One</option>
                <optgroup>
                <option value="1.1">One.One</option>
                <option value="1.2">One.Two</option>
                </optgroup>
                </select>
                HTML,
                [
                    Option::tag()
                        ->value('1')
                        ->content('One'),
                    Optgroup::tag()->options(
                        Option::tag()
                            ->value('1.1')
                            ->content('One.One'),
                        Option::tag()
                            ->value('1.2')
                            ->content('One.Two'),
                    ),
                ],
            ],
        ];
    }

    #[DataProvider('dataItems')]
    public function testItems(string $expected, array $items): void
    {
        $result = Select::widget()
            ->name('item')
            ->items(...$items)
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testOptions(): void
    {
        $result = Select::widget()
            ->name('item')
            ->options(
                Option::tag()
                    ->value('1')
                    ->content('One'),
                Option::tag()
                    ->value('2')
                    ->content('Two'),
            )
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item">
            <option value="1">One</option>
            <option value="2">Two</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOptionsData(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One', '2' => 'Two'])
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item">
            <option value="1">One</option>
            <option value="2">Two</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOptionsDataEncode(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => '<b>One</b>'])
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item">
            <option value="1">&lt;b&gt;One&lt;/b&gt;</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOptionsDataWithoutEncode(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => '<b>One</b>'], false)
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item">
            <option value="1"><b>One</b></option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOptionsDataWithGroups(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData([
                1 => 'One',
                'Test Group' => [
                    2 => 'Two',
                    3 => 'Three',
                ],
            ])
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item">
            <option value="1">One</option>
            <optgroup label="Test Group">
            <option value="2">Two</option>
            <option value="3">Three</option>
            </optgroup>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testOptionsAndGroupsAttributes(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(
                data: [
                    1 => 'One',
                    'Group A' => [
                        2 => 'Two',
                        3 => 'Three',
                    ],
                    'Group B' => [
                        4 => 'Four',
                        5 => 'Five',
                    ],
                ],
                optionsAttributes: [
                    1 => ['data-key' => 42],
                    3 => ['id' => 'UniqueOption'],
                ],
                groupsAttributes: [
                    'Group B' => ['label' => 'Custom Label', 'data-id' => 'Group B'],
                ]
            )
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item">
            <option value="1" data-key="42">One</option>
            <optgroup label="Group A">
            <option value="2">Two</option>
            <option id="UniqueOption" value="3">Three</option>
            </optgroup>
            <optgroup label="Custom Label" data-id="Group B">
            <option value="4">Four</option>
            <option value="5">Five</option>
            </optgroup>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->disabled()
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" disabled>
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->ariaDescribedBy('hint')
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" aria-describedby="hint">
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->ariaLabel('test')
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" aria-label="test">
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->autofocus()
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" autofocus>
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->tabIndex(5)
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" tabindex="5">
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMultiple(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->multiple()
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <input type="hidden" name="item" value>
            <select name="item[]" multiple>
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataPrompt(): array
    {
        return [
            [
                <<<HTML
                <select name="item">
                <option value="1">One</option>
                </select>
                HTML,
                null,
            ],
            [
                <<<HTML
                <select name="item">
                <option value>Please select...</option>
                <option value="1">One</option>
                </select>
                HTML,
                'Please select...',
            ],
        ];
    }

    #[DataProvider('dataPrompt')]
    public function testPrompt(string $expected, ?string $text): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->prompt($text)
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public static function dataPromptOption(): array
    {
        return [
            [
                <<<HTML
                <select name="item">
                <option value="1">One</option>
                </select>
                HTML,
                null,
            ],
            [
                <<<HTML
                <select name="item">
                <option>Please select...</option>
                <option value="1">One</option>
                </select>
                HTML,
                Option::tag()->content('Please select...'),
            ],
        ];
    }

    #[DataProvider('dataPromptOption')]
    public function testPromptOption(string $expected, ?Option $option): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->promptOption($option)
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testRequired(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->required()
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" required>
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSize(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->size(10)
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <select name="item" size="10">
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUnselectValue(): void
    {
        $result = Select::widget()
            ->name('item')
            ->optionsData(['1' => 'One'])
            ->unselectValue('no')
            ->hideLabel()
            ->useContainer(false)
            ->render();

        $expected = <<<HTML
            <input type="hidden" name="item" value="no">
            <select name="item">
            <option value="1">One</option>
            </select>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSingleInvalidValue(): void
    {
        $widget = Select::widget()->value(new stdClass());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Non-multiple Select field requires a string, numeric, bool, Stringable or null value.'
        );
        $widget->render();
    }

    public function testMultipleInvalidValue(): void
    {
        $widget = Select::widget()->value('one')->multiple();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Select field with multiple option requires iterable or null value.');
        $widget->render();
    }

    public function testEnrichFromValidationRulesEnabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = Select::widget()->enrichFromValidationRules()->render();

        $expected = <<<HTML
            <div>
            <select data-test="1"></select>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEnrichFromValidationRulesDisabled(): void
    {
        ThemeContainer::initialize(
            validationRulesEnricher: new StubValidationRulesEnricher([
                'inputAttributes' => ['data-test' => 1],
            ]),
        );

        $html = Select::widget()->render();

        $expected = <<<HTML
            <div>
            <select></select>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testImmutability(): void
    {
        $field = Select::widget();

        $this->assertNotSame($field, $field->items());
        $this->assertNotSame($field, $field->options());
        $this->assertNotSame($field, $field->optionsData([]));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->multiple());
        $this->assertNotSame($field, $field->prompt(null));
        $this->assertNotSame($field, $field->promptOption(null));
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->size(null));
        $this->assertNotSame($field, $field->unselectValue(null));
    }
}
