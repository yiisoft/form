<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;

final class CheckboxListTest extends TestCase
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
                <label>Select one or more colors</label>
                <div>
                <label><input name="CheckboxListForm[color][]" value="red" type="checkbox"> Red</label>
                <label><input name="CheckboxListForm[color][]" value="blue" type="checkbox"> Blue</label>
                </div>
                <div>Color of box.</div>
                </div>
                HTML,
                new InputData(
                    name: 'CheckboxListForm[color]',
                    label: 'Select one or more colors',
                    hint: 'Color of box.',
                    id: 'UID',
                ),
            ],
            'container-valid-class' => [
                <<<HTML
                <div class="valid">
                <div>
                <label><input name="color[]" value="red" type="checkbox"> Red</label>
                <label><input name="color[]" value="blue" type="checkbox"> Blue</label>
                </div>
                </div>
                HTML,
                new InputData(name: 'color', validationErrors: []),
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

        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->inputData($inputData)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testCheckboxWrap(): void
    {
        $result = CheckboxList::widget()
            ->items([
                '1' => 'Red',
                '2' => 'Blue',
            ])
            ->name('test')
            ->checkboxWrapTag('div')
            ->checkboxWrapAttributes(['class' => 'form-check'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <div class="form-check">
            <label><input name="test[]" value="1" type="checkbox"> Red</label>
            </div>
            <div class="form-check">
            <label><input name="test[]" value="2" type="checkbox"> Blue</label>
            </div>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCheckboxWrapClass(): void
    {
        $result = CheckboxList::widget()
            ->items([
                '1' => 'Red',
                '2' => 'Blue',
            ])
            ->name('test')
            ->checkboxWrapTag('div')
            ->checkboxWrapClass('form-check')
            ->addCheckboxWrapClass('form-check-inline')
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <div class="form-check form-check-inline">
            <label><input name="test[]" value="1" type="checkbox"> Red</label>
            </div>
            <div class="form-check form-check-inline">
            <label><input name="test[]" value="2" type="checkbox"> Blue</label>
            </div>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddCheckboxAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue >',
            ])
            ->name('CheckboxListForm[color]')
            ->addCheckboxAttributes(['class' => 'control'])
            ->addCheckboxAttributes(['data-key' => 'x100'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" class="control" data-key="x100" type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" class="control" data-key="x100" type="checkbox"> Blue &gt;</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCheckboxAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->checkboxAttributes(['data-key' => 'x100'])
            ->checkboxAttributes(['class' => 'control'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" class="control" type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" class="control" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddCheckboxLabelAttributes(): void
    {
        $result = CheckboxList::widget()
            ->itemsFromValues(['Red', 'Blue'])
            ->name('CheckboxListForm[color]')
            ->addCheckboxLabelAttributes(['class' => 'control'])
            ->addCheckboxLabelAttributes(['data-key' => 'x100'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label class="control" data-key="x100"><input name="CheckboxListForm[color][]" value="Red" type="checkbox"> Red</label>
            <label class="control" data-key="x100"><input name="CheckboxListForm[color][]" value="Blue" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCheckboxLabelAttributes(): void
    {
        $result = CheckboxList::widget()
            ->itemsFromValues(['Red', 'Blue'])
            ->name('CheckboxListForm[color]')
            ->checkboxLabelAttributes(['data-key' => 'x100'])
            ->checkboxLabelAttributes(['class' => 'control'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label class="control"><input name="CheckboxListForm[color][]" value="Red" type="checkbox"> Red</label>
            <label class="control"><input name="CheckboxListForm[color][]" value="Blue" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testCheckboxLabelWrapDisabled(): void
    {
        $result = CheckboxList::widget()
            ->items([
                1 => 'Red',
                2 => 'Blue',
            ])
            ->name('test')
            ->checkboxLabelWrap(false)
            ->individualInputAttributes([
                1 => ['id' => 'id1'],
                2 => ['id' => 'id2'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <input name="test[]" value="1" id="id1" type="checkbox"> <label for="id1">Red</label>
            <input name="test[]" value="2" id="id2" type="checkbox"> <label for="id2">Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddIndividualInputAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->addIndividualInputAttributes([
                'red' => ['class' => 'control'],
            ])
            ->addIndividualInputAttributes([
                'blue' => ['class' => 'control2'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" class="control" type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" class="control2" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testIndividualInputAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->individualInputAttributes([
                'red' => ['class' => 'control'],
            ])
            ->individualInputAttributes([
                'blue' => ['class' => 'control'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" class="control" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItemsWithoutEncodeLabels(): void
    {
        $result = CheckboxList::widget()
            ->items(
                [
                    'red' => '<b>Red</b>',
                    'blue' => '<b>Blue</b>',
                ],
                false,
            )
            ->name('CheckboxListForm[color]')
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" type="checkbox"> <b>Red</b></label>
            <label><input name="CheckboxListForm[color][]" value="blue" type="checkbox"> <b>Blue</b></label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItemsFromValues(): void
    {
        $result = CheckboxList::widget()
            ->itemsFromValues(['Red', 'Blue >'])
            ->name('color')
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="color[]" value="Red" type="checkbox"> Red</label>
            <label><input name="color[]" value="Blue &gt;" type="checkbox"> Blue &gt;</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItemsFromValuesWithoutEncodeLabels(): void
    {
        $result = CheckboxList::widget()
            ->itemsFromValues(
                [
                    '<b>Red</b>',
                    '<b>Blue</b>',
                ],
                false,
            )
            ->name('CheckboxListForm[color]')
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="&lt;b&gt;Red&lt;/b&gt;" type="checkbox"> <b>Red</b></label>
            <label><input name="CheckboxListForm[color][]" value="&lt;b&gt;Blue&lt;/b&gt;" type="checkbox"> <b>Blue</b></label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testForm(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" form="CreatePost" type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" form="CreatePost" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" disabled type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" disabled type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testUncheckValue(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->uncheckValue(0)
            ->render();

        $expected = <<<HTML
            <div>
            <input type="hidden" name="CheckboxListForm[color]" value="0">
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" type="checkbox"> Red</label>
            <label><input name="CheckboxListForm[color][]" value="blue" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSeparator(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->separator("\n<br>\n")
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="CheckboxListForm[color][]" value="red" type="checkbox"> Red</label>
            <br>
            <label><input name="CheckboxListForm[color][]" value="blue" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testItemFormatter(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->name('CheckboxListForm[color]')
            ->itemFormatter(static fn(CheckboxItem $item) => Html::checkbox($item->name, $item->value) . ' — ' . $item->label)
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <input name="CheckboxListForm[color][]" value="red" type="checkbox"> — Red
            <input name="CheckboxListForm[color][]" value="blue" type="checkbox"> — Blue
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = CheckboxList::widget()->name('test')->value(19);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"CheckboxList" field requires iterable or null value.');
        $field->render();
    }

    public function testWithoutName(): void
    {
        $field = CheckboxList::widget();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('"CheckboxList" field requires non-empty name.');
        $field->render();
    }

    public function testEmptyName(): void
    {
        $field = CheckboxList::widget()->name('');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('"CheckboxList" field requires non-empty name.');
        $field->render();
    }

    public function testInvalidClassesWithCustomError(): void
    {
        $inputData = new InputData('company', ['red']);

        $result = CheckboxList::widget()
            ->invalidClass('invalidWrap')
            ->inputValidClass('validWrap')
            ->inputInvalidClass('invalid')
            ->inputValidClass('valid')
            ->inputData($inputData)
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->error('Value cannot be blank.')
            ->render();

        $expected = <<<HTML
            <div class="invalidWrap">
            <div>
            <label><input name="company[]" value="red" class="invalid" checked type="checkbox"> Red</label>
            <label><input name="company[]" value="blue" class="invalid" type="checkbox"> Blue</label>
            </div>
            <div>Value cannot be blank.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataBeforeCheckbox(): array
    {
        return [
            'string' => ['<b>*</b>', '<b>*</b>'],
            'stringable' => ['<b>*</b>', new StringableObject('<b>*</b>')],
        ];
    }

    #[DataProvider('dataBeforeCheckbox')]
    public function testBeforeCheckbox(string $expectedContent, string|Stringable $content): void
    {
        $result = CheckboxList::widget()
            ->name('color')
            ->items(['red' => 'Red', 'blue' => 'Blue'])
            ->beforeCheckbox($content)
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label>$expectedContent<input name="color[]" value="red" type="checkbox"> Red</label>
            <label>$expectedContent<input name="color[]" value="blue" type="checkbox"> Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public static function dataAfterCheckbox(): array
    {
        return [
            'string' => ['<b>*</b>', '<b>*</b>'],
            'stringable' => ['<b>*</b>', new StringableObject('<b>*</b>')],
        ];
    }

    #[DataProvider('dataAfterCheckbox')]
    public function testAfterCheckbox(string $expectedContent, string|Stringable $content): void
    {
        $result = CheckboxList::widget()
            ->name('color')
            ->items(['red' => 'Red', 'blue' => 'Blue'])
            ->afterCheckbox($content)
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input name="color[]" value="red" type="checkbox">$expectedContent Red</label>
            <label><input name="color[]" value="blue" type="checkbox">$expectedContent Blue</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = CheckboxList::widget();

        $this->assertNotSame($field, $field->checkboxWrapTag('div'));
        $this->assertNotSame($field, $field->checkboxWrapAttributes([]));
        $this->assertNotSame($field, $field->checkboxWrapClass());
        $this->assertNotSame($field, $field->addCheckboxWrapClass());
        $this->assertNotSame($field, $field->checkboxAttributes([]));
        $this->assertNotSame($field, $field->addCheckboxAttributes([]));
        $this->assertNotSame($field, $field->checkboxLabelAttributes([]));
        $this->assertNotSame($field, $field->addCheckboxLabelAttributes([]));
        $this->assertNotSame($field, $field->checkboxLabelWrap(false));
        $this->assertNotSame($field, $field->individualInputAttributes([]));
        $this->assertNotSame($field, $field->addIndividualInputAttributes([]));
        $this->assertNotSame($field, $field->items([]));
        $this->assertNotSame($field, $field->itemsFromValues([]));
        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->uncheckValue(null));
        $this->assertNotSame($field, $field->separator(''));
        $this->assertNotSame($field, $field->itemFormatter(null));
        $this->assertNotSame($field, $field->beforeCheckbox(''));
        $this->assertNotSame($field, $field->afterCheckbox(''));
    }
}
