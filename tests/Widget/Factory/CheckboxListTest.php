<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

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

    public function testContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-array" class="test-class">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'containerAttributes()' => [['class' => 'test-class']],
                'items()' => [$this->sex],
            ])->render(),
        );
    }

    public function testContainerTag(): void
    {
        $expected = <<<'HTML'
        <span id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </span>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'containerTag()' => ['span'],
                'items()' => [$this->sex],
            ])->render(),
        );
    }

    public function testContainerTagWithNull(): void
    {
        $expected = <<<'HTML'
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'containerTag()' => [null],
                'items()' => [$this->sex],
            ])->render(),
        );
    }

    public function testIndividualItemsAttributes(): void
    {
        // set disabled `true`.
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
                'items()' => [$this->sex],
            ])->render(),
        );

        // set readonly `true.
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" readonly> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" readonly> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'individualItemsAttributes()' => [[1 => ['readonly' => true], 2 => ['readonly' => true]]],
                'items()' => [$this->sex],
            ])->render(),
        );
    }

    public function testItemsAttributes(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'items()' => [$this->sex],
                'itemsAttributes()' => [['class' => 'test-class']],
            ])->render(),
        );
    }

    public function testItemFormater(): void
    {
        $itemsFormater = static function (CheckboxItem $item) {
            return $item->checked
                ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
                : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
        };
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type='checkbox' name='TypeForm[array][]' value='1'> Female</label>
        <label><input type='checkbox' name='TypeForm[array][]' value='2'> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'items()' => [$this->sex],
                'itemsFormatter()' => [$itemsFormater],
            ])->render(),
        );
    }

    public function testItemsFromValues(): void
    {
        $this->formModel->setAttribute('array', ['Male']);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="Female"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="Male" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'itemsFromValues()' => [$this->sex],
            ])->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'items()' => [$this->sex],
            ])->render(),
        );
    }

    public function testSeparator(): void
    {
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>&#9866;<label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget([
                'for()' => [$this->formModel, 'array'],
                'items()' => [$this->sex],
                'separator()' => ['&#9866;'],
            ])->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->formModel->setAttribute('array', null);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget(['for()' => [$this->formModel, 'array'], 'items()' => [$this->sex]])->render(),
        );

        // value iterable
        $this->formModel->setAttribute('array', [2]);
        $expected = <<<'HTML'
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            CheckboxList::widget(['for()' => [$this->formModel, 'array'], 'items()' => [$this->sex]])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->setAttribute('int', 1);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CheckboxList widget must be a array or null value.');
        CheckboxList::widget(['for()' => [$this->formModel, 'int']])->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
