<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Widget\RadioList\RadioItem;

final class FieldRadioListTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $sex = [1 => 'Female', 2 => 'Male'];

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int" autofocus>
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testContainerAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int" class="test-class">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(
                    new TypeForm(),
                    'int',
                    ['containerAttributes()' => [['class' => 'test-class']], 'items()' => [$this->sex]],
                )
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testContainerTag(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <span id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </span>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(new TypeForm(), 'int', ['containerTag()' => ['span'], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testContainerTagWithFalse(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(new TypeForm(), 'int', ['containerTag()' => [null], 'items()' => [$this->sex]])
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" disabled> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2" disabled> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">Int</label>
        <div id="id-test">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testIndividualItemsAttributes(): void
    {
        // Set disabled `[1 => ['disabled' => 'true']]`, `[2 => ['class' => 'test-class']]`.
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1" disabled> Female</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(
                    new TypeForm(),
                    'int',
                    [
                        'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
                        'items()' => [$this->sex],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testItemsAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" class="test-class" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(
                    new TypeForm(),
                    'int',
                    ['items()' => [$this->sex], 'itemsAttributes()' => [['class' => 'test-class']]],
                )
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testItemFormater(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type='checkbox' name='TypeForm[int]' value='1'> Female</label>
        <label><input type='checkbox' name='TypeForm[int]' value='2'> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(
                    new TypeForm(),
                    'int',
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

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testItemsFromValues(): void
    {
        $formModel = new TypeForm();

        // Value string `Male`.
        $formModel->setAttribute('string', 'Male');

        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="Female"> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="Male" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList($formModel, 'string', ['itemsFromValues()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="name-test" value="1"> Female</label>
        <label><input type="radio" name="name-test" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->name('name-test')->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testSeparator(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->radioList(new TypeForm(), 'int', ['items()' => [$this->sex], 'separator()' => [PHP_EOL]])
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int" tabindex="1">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->tabindex(1)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
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
                ->radioList(new TypeForm(), 'int', ['items()' => [$this->sex], 'uncheckValue()' => ['0']])
                ->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
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
                ->radioList(new TypeForm(), 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->value(false)
                ->render(),
        );

        // Value bool `true`.
        $expected = <<<HTML
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
                ->radioList(new TypeForm(), 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->value(true)
                ->render(),
        );

        // Value int `1`.
        $expected = <<<HTML
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
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->value(1)->render(),
        );

        // Value int `2`.
        $expected = <<<HTML
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
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->value(2)->render(),
        );

        // Value string '1'
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'string', ['items()' => [$this->sex]])->value('1')->render(),
        );

        // Value string '2'
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'string', ['items()' => [$this->sex]])->value('2')->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->value(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RadioList widget value can not be an iterable or an object.');
        Field::widget()->radioList(new TypeForm(), 'array')->render();
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testValueWithForm(): void
    {
        $formModel = new TypeForm();

        // Value bool `false`.
        $formModel->setAttribute('bool', false);
        $expected = <<<HTML
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
                ->radioList($formModel, 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->render(),
        );

        // Value bool `true`.
        $formModel->setAttribute('bool', true);
        $expected = <<<HTML
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
                ->radioList($formModel, 'bool', ['items()' => [[0 => 'Female', 1 => 'Male']]])
                ->render(),
        );

        // Value int `1`.
        $formModel->setAttribute('int', 1);
        $expected = <<<HTML
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
            Field::widget()->radioList($formModel, 'int', ['items()' => [$this->sex]])->render(),
        );

        // Value int `2`.
        $formModel->setAttribute('int', 2);
        $expected = <<<HTML
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
            Field::widget()->radioList($formModel, 'int', ['items()' => [$this->sex]])->render(),
        );

        // Value string '1'
        $formModel->setAttribute('string', '1');
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1" checked> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList($formModel, 'string', ['items()' => [$this->sex]])->render(),
        );

        // Value string '2'
        $formModel->setAttribute('string', '2');
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <div id="typeform-string">
        <label><input type="radio" name="TypeForm[string]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[string]" value="2" checked> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList($formModel, 'string', ['items()' => [$this->sex]])->render(),
        );

        // Value `null`.
        $formModel->setAttribute('int', null);
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList($formModel, 'int', ['items()' => [$this->sex]])->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>Int</label>
        <div>
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->id(null)->render(),
        );
    }

    /**
     * @throws InvalidConfigException|NotFoundException|NotInstantiableException|CircularReferenceException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <div id="typeform-int">
        <label><input type="radio" name="TypeForm[int]" value="1"> Female</label>
        <label><input type="radio" name="TypeForm[int]" value="2"> Male</label>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->radioList(new TypeForm(), 'int', ['items()' => [$this->sex]])->name(null)->render(),
        );
    }
}
