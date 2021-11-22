<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FieldRadioListTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $sex = [1 => 'Female', 2 => 'Male'];

    public function testContainerAttributes(): void
    {
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int" class="test-class">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(['containerAttributes()' => [['class' => 'test-class']], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    public function testContainerTag(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <span id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(['containerTag()' => ['span'], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    public function testContainerTagWithFalse(): void
    {
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(['containerTag()' => [null], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    public function testIndividualItemsAttributes(): void
    {
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" disabled> Female</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(
                    [
                        'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
                        'items()' => [$this->sex],
                    ],
                )
                ->render(),
        );
    }

    public function testItemsAttributes(): void
    {
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(['items()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]])
                ->render(),
        );
    }

    public function testItemFormater(): void
    {
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type='checkbox' name='TypeForm[int]' value='1'> Female</label>
        <label><input type='checkbox' name='TypeForm[int]' value='2' checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(
                    [
                        'items()' => [$this->sex],
                        'itemsFormatter()' => [
                            static function (RadioItem $item) {
                                return $item->checked
                                    ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
                                    : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
                            },
                        ],
                    ],
                )
                ->render(),
        );
    }

    public function testItemsFromValues(): void
    {
        $this->formModel->setAttribute('string', 'Male');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="Female"> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="Male" checked> Male</label>
        </div>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'string')
                ->radioList(['itemsFromValues()' => [$this->sex]])
                ->render(),
        );
    }

    public function testRender(): void
    {
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->radioList(['items()' => [$this->sex]])->render(),
        );
    }

    public function testSeparator(): void
    {
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(['items()' => [$this->sex], 'separator()' => [PHP_EOL]])
                ->render(),
        );
    }

    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <input type="hidden" name="TypeForm[int]" value="0">
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'int')
                ->radioList(['items()' => [$this->sex], 'uncheckValue()' => ['0']])
                ->render(),
        );
    }

    public function testValue(): void
    {
        // value bool false
        $this->formModel->setAttribute('bool', false);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <div id="typeform-bool">
        <label><input type="radio" name="TypeForm[bool]" value="0" checked> Female</label>
        <label><input type="radio" name="TypeForm[bool]" value="1"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radioList(['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->render(),
        );

        // value bool true
        $this->formModel->setAttribute('bool', true);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-bool">Bool</label>
        <div id="typeform-bool">
        <label><input type="radio" name="TypeForm[bool]" value="0"> Female</label>
        <label><input type="radio" name="TypeForm[bool]" value="1" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->for($this->formModel, 'bool')
                ->radioList(['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->render(),
        );

        // value int 0
        $this->formModel->setAttribute('int', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->radioList(['items()' => [$this->sex]])->render(),
        );

        // value int 1
        $this->formModel->setAttribute('int', 2);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'int')->radioList(['items()' => [$this->sex]])->render(),
        );

        // value string '1'
        $this->formModel->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> Male</label>
        </div>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->radioList(['items()' => [$this->sex]])->render(),
        );

        // value string '2'
        $this->formModel->setAttribute('string', '2');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2" checked> Male</label>
        </div>
        <div>Write your text string.</div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'string')->radioList(['items()' => [$this->sex]])->render(),
        );

        // value null
        $this->formModel->setAttribute('toNull', null);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-tonull">To Null</label>
        <div id="typeform-tonull">
        <label><input type="radio" name="TypeForm[toNull]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[toNull]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->for($this->formModel, 'toNull')->radioList(['items()' => [$this->sex]])->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RadioList widget value can not be an iterable or an object.');
        Field::widget()->for($this->formModel, 'array')->radioList()->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
