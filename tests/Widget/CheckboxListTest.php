<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\CheckboxList;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxListTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $sex = [1 => 'Female', 2 => 'Male'];
    private TypeForm $formModel;

    public function testContainerAttributes(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array" class="test-class">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->containerAttributes(['class' => 'test-class'])
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTag(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [1]]]);
        $expected = <<<'HTML'
        <span id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" checked> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </span>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->containerTag('span')
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTagWithNull(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [1]]]);
        $expected = <<<'HTML'
        <label><input type="checkbox" name="TypeForm[array][]" value="1" checked> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->containerTag(null)
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" disabled> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()->config($this->formModel, 'array')->disabled(true)->items($this->sex)->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testIndividualItemsAttributes(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->individualItemsAttributes([1 => ['disabled' => true], 2 => ['class' => 'test-class']])
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemsAttributes(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->items($this->sex)
            ->itemsAttributes(['class' => 'test-class'])
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemFormater(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type='checkbox' name='TypeForm[array][]' value='1'> Female</label>
        <label><input type='checkbox' name='TypeForm[array][]' value='2' checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->itemsFormatter(
                static function (CheckboxItem $item) {
                    return $item->checked
                        ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
                        : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
                }
            )
            ->items($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testImmutability(): void
    {
        $checkboxList = CheckboxList::widget();
        $this->assertNotSame($checkboxList, $checkboxList->containerAttributes([]));
        $this->assertNotSame($checkboxList, $checkboxList->containerTag());
        $this->assertNotSame($checkboxList, $checkboxList->individualItemsAttributes());
        $this->assertNotSame($checkboxList, $checkboxList->items());
        $this->assertNotSame($checkboxList, $checkboxList->itemsAttributes());
        $this->assertNotSame($checkboxList, $checkboxList->itemsFormatter(null));
        $this->assertNotSame($checkboxList, $checkboxList->itemsFromValues());
        $this->assertNotSame($checkboxList, $checkboxList->readonly());
        $this->assertNotSame($checkboxList, $checkboxList->separator(''));
    }

    public function testItemsFromValues(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => ['Male']]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="Female"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="Male" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->itemsFromValues($this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testReadOnly(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" readonly> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" checked readonly> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'array')->items($this->sex)->readonly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [1]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" checked> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'array')->items($this->sex)->render(),
        );
    }

    public function testSeparator(): void
    {
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>&#9866;<label><input type="checkbox" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $html = CheckboxList::widget()
            ->config($this->formModel, 'array')
            ->items($this->sex)
            ->separator('&#9866;')
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValue(): void
    {
        // value iterable
        $this->formModel->load(['TypeForm' => ['array' => [2]]]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget()->config($this->formModel, 'array')->items($this->sex)->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->load(['TypeForm' => ['int' => '1']]);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CheckboxList widget value must be an array or null.');
        CheckboxList::widget()->config($this->formModel, 'int')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
