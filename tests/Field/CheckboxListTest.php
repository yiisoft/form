<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Tests\Support\Form\CheckboxListForm;
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
    }

    public function testBase(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new CheckboxListForm(), 'color')
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

    public function testCheckboxAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new CheckboxListForm(), 'color')
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

    public function testReplaceCheckboxAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new CheckboxListForm(), 'color')
            ->checkboxAttributes(['data-key' => 'x100'])
            ->replaceCheckboxAttributes(['class' => 'control'])
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

    public function testIndividualInputAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new CheckboxListForm(), 'color')
            ->individualInputAttributes([
                'red' => ['class' => 'control'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <label>Select one or more colors</label>
            <div>
            <label><input type="checkbox" class="control" name="CheckboxListForm[color][]" value="red"> Red</label>
            <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
            </div>
            <div>Color of box.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testReplaceIndividualInputAttributes(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new CheckboxListForm(), 'color')
            ->individualInputAttributes([
                'red' => ['class' => 'control'],
            ])
            ->replaceIndividualInputAttributes([
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
            ->attribute(new CheckboxListForm(), 'color')
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
            ->attribute(new CheckboxListForm(), 'color')
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
            ->attribute(new CheckboxListForm(), 'color')
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
            ->attribute(new CheckboxListForm(), 'color')
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
            ->attribute(new CheckboxListForm(), 'color')
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
            ->attribute(new CheckboxListForm(), 'color')
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
            ->attribute(new CheckboxListForm(), 'color')
            ->itemFormatter(static function (CheckboxItem $item) {
                return Html::checkbox($item->name, $item->value) . ' — ' . $item->label;
            })
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
        $field = CheckboxList::widget()->attribute(new CheckboxListForm(), 'age');

        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('"CheckboxList" field requires iterable or null value.');
        $field->render();
    }

    public function testImmutability(): void
    {
        $field = CheckboxList::widget();

        $this->assertNotSame($field, $field->checkboxAttributes([]));
        $this->assertNotSame($field, $field->replaceCheckboxAttributes([]));
        $this->assertNotSame($field, $field->individualInputAttributes([]));
        $this->assertNotSame($field, $field->replaceIndividualInputAttributes([]));
        $this->assertNotSame($field, $field->items([]));
        $this->assertNotSame($field, $field->itemsFromValues([]));
        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->uncheckValue(null));
        $this->assertNotSame($field, $field->separator(''));
        $this->assertNotSame($field, $field->itemFormatter(null));
    }
}
