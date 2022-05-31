<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StdClass;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;

final class FieldCheckBoxListTest extends TestCase
{
    use TestTrait;

    /** @var string[]  */
    private array $sex = [1 => 'Female', 2 => 'Male'];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array" autofocus>
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->autofocus()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(
                    new TypeForm(),
                    'array',
                    ['containerAttributes()' => [['class' => 'test-class']], 'items()' => [$this->sex]],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['containerTag()' => ['span'], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testContainerTagWithNull(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['containerTag()' => [null], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->disabled()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="id-test">Array</label>
        <div id="id-test">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testIndividualItemsAttributes(): void
    {
        // Set disabled `[1 => ['disabled' => 'true']]`, `[2 => ['class' => 'test-class']]`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="TypeForm[array][]" value="1" disabled> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(
                    new TypeForm(),
                    'array',
                    [
                        'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
                        'items()' => [$this->sex],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsAttributes(): void
    {
        // Set `['class' => 'test-class']]`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(
                    new TypeForm(),
                    'array',
                    ['items()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]]
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(
                    new TypeForm(),
                    'array',
                    [
                        'items()' => [$this->sex],
                        'itemsFormatter()' => [
                            static function (CheckboxItem $item) {
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

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testItemsFromValues(): void
    {
        $formModel = new TypeForm();

        // Value string `Male`.
        $formModel->setAttribute('array', ['Male']);

        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="Female"> Female</label>
        <label><input type="checkbox" class="test-class" name="TypeForm[array][]" value="Male" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(
                    $formModel,
                    'array',
                    ['itemsFromValues()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]]
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array">
        <label><input type="checkbox" name="name-test[]" value="1"> Female</label>
        <label><input type="checkbox" name="name-test[]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
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
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex], 'separator()' => ['&#9866;']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <div id="typeform-array" tabindex="1">
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->tabindex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value iterable `[2]`.
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
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->value([2])
                ->render(),
        );

        // Value `null`.
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
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->value(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $formModel = new TypeForm();

        // Value object `stdClass`.
        $formModel->setAttribute('object', new StdClass());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('CheckboxList widget must be a array or null value.');
        Field::widget()
            ->checkboxList($formModel, 'object')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value iterable `[2]`.
        $formModel->setAttribute('array', [2]);

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
            Field::widget()
                ->checkboxList($formModel, 'array', ['items()' => [$this->sex]])
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('array', null);

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
            Field::widget()
                ->checkboxList($formModel, 'array', ['items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Array</label>
        <div>
        <label><input type="checkbox" name="TypeForm[array][]" value="1"> Female</label>
        <label><input type="checkbox" name="TypeForm[array][]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->id(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
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
            Field::widget()
                ->checkboxList(new TypeForm(), 'array', ['items()' => [$this->sex]])
                ->name(null)
                ->render(),
        );
    }
}
