<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\FormModelInputData;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Tests\Support\Form\CheckboxListForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddCheckboxAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->addCheckboxAttributes(['class' => 'control'])
            ->addCheckboxAttributes(['data-key' => 'x100'])
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="red" data-key="x100"> Red</label>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="blue" data-key="x100"> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->checkboxAttributes(['data-key' => 'x100'])
            ->checkboxAttributes(['class' => 'control'])
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="red"> Red</label>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->addIndividualInputAttributes([
                'red' => ['class' => 'control'],
            ])
            ->addIndividualInputAttributes([
                'blue' => ['class' => 'control2'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="red"> Red</label>
            <label><input type="checkbox" class="control2" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->individualInputAttributes([
                'red' => ['class' => 'control'],
            ])
            ->individualInputAttributes([
                'blue' => ['class' => 'control'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
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
                false
            )
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> <b>Red</b></label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> <b>Blue</b></label>
            </div>
            <div>Color of box.</div>
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
                false
            )
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="&lt;b&gt;Red&lt;/b&gt;"> <b>Red</b></label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="&lt;b&gt;Blue&lt;/b&gt;"> <b>Blue</b></label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red" form="CreatePost"> Red</label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue" form="CreatePost"> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red" disabled> Red</label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue" disabled> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->uncheckValue(0)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <input type="hidden" name="CheckboxListForm[color]" value="0">
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->separator("\n<br>\n")
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
            <br>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
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
            ->inputData(new FormModelInputData(new CheckboxListForm(), 'color'))
            ->itemFormatter(static fn (CheckboxItem $item) => Html::checkbox($item->name, $item->value) . ' — ' . $item->label)
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <input type="checkbox" name="CheckboxListForm[color][]" value="red"> — Red
            <input type="checkbox" name="CheckboxListForm[color][]" value="blue"> — Blue
            </div>
            <div>Color of box.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvalidValue(): void
    {
        $field = CheckboxList::widget()->inputData(new FormModelInputData(new CheckboxListForm(), 'age'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"CheckboxList" field requires iterable or null value.');
        $field->render();
    }

    public function testImmutability(): void
    {
        $field = CheckboxList::widget();

        $this->assertNotSame($field, $field->checkboxAttributes([]));
        $this->assertNotSame($field, $field->addCheckboxAttributes([]));
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
