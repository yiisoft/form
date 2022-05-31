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
use Yiisoft\Form\Tests\TestSupport\Form\ValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Html\Tag\Option;

final class FieldSelectTest extends TestCase
{
    use TestTrait;

    /** @var string[] */
    private array $cities = [
        '1' => 'Moscu',
        '2' => 'San Petersburgo',
        '3' => 'Novosibirsk',
        '4' => 'Ekaterinburgo',
    ];
    /** @var string[][] */
    private array $citiesGroups = [
        '1' => [
            '2' => ' Moscu',
            '3' => ' San Petersburgo',
            '4' => ' Novosibirsk',
            '5' => ' Ekaterinburgo',
        ],
        '2' => [
            '6' => 'Santiago',
            '7' => 'Concepcion',
            '8' => 'Chillan',
        ],
    ];
    /** @var string[][] */
    private array $groups = [
        '1' => ['label' => 'Russia'],
        '2' => ['label' => 'Chile'],
    ];

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]" autofocus>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->autofocus()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]" disabled>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->disabled()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="validatorform-required">Required</label>
        <select id="validatorform-required" name="ValidatorForm[required]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new ValidatorForm(), 'required', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGroups(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <optgroup label="Russia">
        <option value="2"> Moscu</option>
        <option value="3"> San Petersburgo</option>
        <option value="4"> Novosibirsk</option>
        <option value="5"> Ekaterinburgo</option>
        </optgroup>
        <optgroup label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->citiesGroups], 'groups()' => [$this->groups]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGroupsItemsAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <optgroup label="Russia">
        <option value="2" disabled> Moscu</option>
        <option value="3"> San Petersburgo</option>
        <option value="4"> Novosibirsk</option>
        <option value="5"> Ekaterinburgo</option>
        </optgroup>
        <optgroup label="Chile">
        <option value="6">Santiago</option>
        <option value="7">Concepcion</option>
        <option value="8">Chillan</option>
        </optgroup>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new TypeForm(),
                    'int',
                    [
                        'items()' => [$this->citiesGroups],
                        'groups()' => [$this->groups],
                        'itemsAttributes()' => [['2' => ['disabled' => true]]],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <div>
        <label for="id-test">Int</label>
        <select id="id-test" name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->id('id-test')
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="hidden" name="TypeForm[array]" value="0">
        <select id="typeform-array" name="TypeForm[array][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new TypeForm(),
                    'array',
                    ['items()' => [$this->cities], 'unselectValue()' => ['0'], 'multiple()' => [true]],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="name-test">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->name('name-test')
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOptionsDataWithEncode(): void
    {
        $cities = [
            '1' => '<b>Moscu</b>',
            '2' => 'San Petersburgo',
            '3' => 'Novosibirsk',
            '4' => 'Ekaterinburgo',
        ];

        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1">&lt;b&gt;Moscu&lt;/b&gt;</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->encode(true)
                ->select(new TypeForm(), 'int', ['optionsData()' => [$cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPrompt(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities], 'prompt()' => ['Select City Birth']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPromptTag(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="0" selected>Select City Birth</option>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new TypeForm(),
                    'int',
                    [
                        'items()' => [$this->cities],
                        'promptTag()' => [Option::tag()
                            ->content('Select City Birth')
                            ->value(0)],
                    ],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]" required>
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->required()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSizeWithMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <input type="hidden" name="TypeForm[int]" value>
        <select id="typeform-int" name="TypeForm[int][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities], 'multiple()' => [true], 'size()' => [4]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]" tabindex="1">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->tabindex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUnselectValueWithMultiple(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="hidden" name="TypeForm[array]" value="0">
        <select id="typeform-array" name="TypeForm[array][]" multiple size="4">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(
                    new TypeForm(),
                    'array',
                    ['items()' => [$this->cities], 'unselectValue()' => ['0'], 'multiple()' => [true]],
                )
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value int `1`.
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->value(1)
                ->render(),
        );

        // Value int `2`.
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->value(2)
                ->render(),
        );

        // Value iterable `[2, 3]`.
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <select id="typeform-array" name="TypeForm[array]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'array', ['items()' => [$this->cities]])
                ->value([2, 3])
                ->render(),
        );

        // Value string `1`.
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <select id="typeform-string" name="TypeForm[string]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'string', ['items()' => [$this->cities]])
                ->value('1')
                ->render(),
        );

        // Value string `2`.
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <select id="typeform-string" name="TypeForm[string]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'string', ['items()' => [$this->cities]])
                ->value('2')
                ->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
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
        $this->expectExceptionMessage('Select widget value can not be an object.');
        Field::widget()
            ->select($formModel, 'object')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value int `1`.
        $formModel->setAttribute('int', 1);
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select($formModel, 'int', ['items()' => [$this->cities]])
                ->render(),
        );

        // Value int `2`.
        $formModel->setAttribute('int', 2);
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select($formModel, 'int', ['items()' => [$this->cities]])
                ->render(),
        );

        // Value iterable `[2, 3]`.
        $formModel->setAttribute('array', [2, 3]);
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <select id="typeform-array" name="TypeForm[array]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3" selected>Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select($formModel, 'array', ['items()' => [$this->cities]])
                ->render(),
        );

        // Value string `1`.
        $formModel->setAttribute('string', '1');
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <select id="typeform-string" name="TypeForm[string]">
        <option value="1" selected>Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select($formModel, 'string', ['items()' => [$this->cities]])
                ->render(),
        );

        // Value string '2'.
        $formModel->setAttribute('string', '2');
        $expected = <<<HTML
        <div>
        <label for="typeform-string">String</label>
        <select id="typeform-string" name="TypeForm[string]">
        <option value="1">Moscu</option>
        <option value="2" selected>San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select($formModel, 'string', ['items()' => [$this->cities]])
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('int', null);
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int" name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select($formModel, 'int', ['items()' => [$this->cities]])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <label>Int</label>
        <select name="TypeForm[int]">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->id(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-int">Int</label>
        <select id="typeform-int">
        <option value="1">Moscu</option>
        <option value="2">San Petersburgo</option>
        <option value="3">Novosibirsk</option>
        <option value="4">Ekaterinburgo</option>
        </select>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->select(new TypeForm(), 'int', ['items()' => [$this->cities]])
                ->name(null)
                ->render(),
        );
    }
}
