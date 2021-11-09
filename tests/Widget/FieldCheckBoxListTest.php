<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StdClass;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldCheckBoxListTest extends TestCase
{
    use TestTrait;

    /** @var string[]  */
    private array $sex = [1 => 'Female', 2 => 'Male'];
    private TypeForm $formModel;

    public function testContainerAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array" class="test-class">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['containerAttributes' => ['class' => 'test-class']], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTag(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <span id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </span>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['containerTag' => 'span'], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerTagWithNull(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['containerTag' => null], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" disabled> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['disabled' => true], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testIndividualItemsAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(
                [
                    'individualItemsAttributes' => [1 => ['disabled' => true], 2 => ['class' => 'test-class']],
                ],
                $this->sex,
            )
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemsAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['itemsAttributes' => ['class' => 'test-class']], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemFormater(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type='checkbox' name='TypeForm[array][]' value='1'> Female</label>
        <label><input type='checkbox' name='TypeForm[array][]' value='2'> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(
                [
                    'itemsFormatter' => static function (CheckboxItem $item) {
                        return $item->checked
                            ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
                            : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
                    },
                ],
                $this->sex
            )
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemsFromValues(): void
    {
        $this->formModel->setAttribute('array', ['Male']);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="Female"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="Male" checked> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['itemsAttributes' => ['class' => 'test-class']], [], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testReadOnly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" readonly> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" readonly> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->config($this->formModel, 'array')
                ->checkboxList(['readonly' => true], $this->sex)
                ->render(),
        );
    }

    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'array')->checkboxList([], $this->sex)->render(),
        );
    }

    public function testSeparator(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>&#9866;<label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $html = Field::widget()
            ->config($this->formModel, 'array')
            ->checkboxList(['separator' => '&#9866;'], $this->sex)
            ->render();
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testValue(): void
    {
        // value null
        $this->formModel->setAttribute('array', null);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'array')->checkboxList([], $this->sex)->render(),
        );

        // value iterable
        $this->formModel->setAttribute('array', [2]);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->config($this->formModel, 'array')->checkboxList([], $this->sex)->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->setAttribute('object', new StdClass());
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CheckboxList widget must be a array or null value.');
        Field::widget()->config($this->formModel, 'object')->checkboxList()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
