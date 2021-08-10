<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StdClass;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\CheckboxList;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxListTest extends TestCase
{
    use TestTrait;

    private array $sex = ['Female', 'Male'];
    private TypeForm $formModel;

    public function testContainerAttributes(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div id="typeform-int" class="test-class">
        <label><input type="checkbox" name="TypeForm[int][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int')
            ->containerAttributes(['class' => 'test-class'])
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTag(): void
    {
        $expected = <<<'HTML'
        <tag-test id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0" checked> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1"> Male</label>
        </tag-test>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int')
            ->containerTag('tag-test')
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerWithNull(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <label><input type="checkbox" name="TypeForm[int][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" checked> Male</label>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int')
            ->containerTag(null)
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0" checked disabled> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" disabled> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()->config($this->formModel, 'int')->disabled()->items($this->sex)->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testForceUncheckedValue(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[int]" value="0">
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int', ['forceUncheckedValue' => '0'])
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testImmutability(): void
    {
        $checkboxList = CheckboxList::widget();
        $this->assertNotSame($checkboxList, $checkboxList->containerAttributes([]));
        $this->assertNotSame($checkboxList, $checkboxList->containerTag(null));
        $this->assertNotSame($checkboxList, $checkboxList->disabled());
        $this->assertNotSame(
            $checkboxList,
            $checkboxList->itemFormater(
                static function (CheckboxItem $item): string {
                    return '';
                }
            ),
        );
        $this->assertNotSame($checkboxList, $checkboxList->items());
        $this->assertNotSame($checkboxList, $checkboxList->itemsAttributes());
        $this->assertNotSame($checkboxList, $checkboxList->readOnly());
        $this->assertNotSame($checkboxList, $checkboxList->separator(''));
    }

    public function testItemsAttributes(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" class="test-class" name="TypeForm[int][]" value="0"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[int][]" value="1" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int')
            ->items($this->sex)
            ->itemsAttributes(['class' => 'test-class'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemFormater(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-int">
        <div class='test-class'><label><input tabindex='0' class='test-class' type='checkbox' name='TypeForm[int][]' value='0' checked> Female</label></div>
        <div class='test-class'><label><input tabindex='1' class='test-class' type='checkbox' name='TypeForm[int][]' value='1'> Male</label></div>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int')
            ->items($this->sex)
            ->itemFormater(static function (CheckboxItem $item) {
                return $item->checked
                    ? "<div class='test-class'><label><input tabindex='{$item->index}' class='test-class' type='checkbox' name='{$item->name}' value='{$item->value}' checked> {$item->label}</label></div>"
                    : "<div class='test-class'><label><input tabindex='{$item->index}' class='test-class' type='checkbox' name='{$item->name}' value='{$item->value}'> {$item->label}</label></div>";
            })
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testReadOnly(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0" readonly> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" checked readonly> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'int')->items($this->sex)->readOnly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'int')->items($this->sex)->render(),
        );
    }

    public function testSeparator(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0"> Female</label>&#9866;<label><input type="checkbox" name="TypeForm[int][]" value="1" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'int')
            ->items($this->sex)
            ->separator('&#9866;')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValues(): void
    {
        // value int 0
        $this->formModel->setAttribute('int', 0);
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0" checked> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1"> Male</label>
        </div>
        HTML;
        $this->assertSame(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'int')->items($this->sex)->render(),
        );

        // value int 1
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div id="typeform-int">
        <label><input type="checkbox" name="TypeForm[int][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[int][]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertSame(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'int')->items($this->sex)->render(),
        );

        // value iterable
        $this->formModel->setAttribute('array', [0, 1]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="0" checked> Moscu</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="1" checked> San Petesburgo</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'array')->items(['Moscu', 'San Petesburgo'])->render(),
        );

        // value string '0'
        $this->formModel->setAttribute('string', 0);
        $expected = <<<'HTML'
        <div id="typeform-string">
        <label><input type="checkbox" name="TypeForm[string][]" value="0" checked> Female</label>
        <label><input type="checkbox" name="TypeForm[string][]" value="1"> Male</label>
        </div>
        HTML;
        $this->assertSame(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'string')->items($this->sex)->render(),
        );

        // value string '1'
        $this->formModel->setAttribute('string', 1);
        $expected = <<<'HTML'
        <div id="typeform-string">
        <label><input type="checkbox" name="TypeForm[string][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[string][]" value="1" checked> Male</label>
        </div>
        HTML;
        $this->assertSame(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'string')->items($this->sex)->render(),
        );

        // value null
        $this->formModel->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <div id="typeform-tonull">
        <label><input type="checkbox" name="TypeForm[toNull][]" value="0"> Female</label>
        <label><input type="checkbox" name="TypeForm[toNull][]" value="1"> Male</label>
        </div>
        HTML;
        $this->assertSame(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'toNull')->items($this->sex)->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->setAttribute('object', new StdClass());
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value must be a bool|float|int|iterable|string|Stringable|null.');
        $html = CheckboxList::widget()->config($this->formModel, 'object')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
