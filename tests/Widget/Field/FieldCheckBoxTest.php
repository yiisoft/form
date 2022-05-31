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
use Yiisoft\Form\Tests\TestSupport\Form\ValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;

final class FieldCheckBoxTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAnyLabel(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->label(null)
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" autofocus> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->autofocus()
                ->checkbox(new TypeForm(), 'int')
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testChecked(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int', ['checked()' => []])
                ->value(1)
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
        <input type="hidden" name="TypeForm[int]" value="0" disabled><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" disabled> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int')
                ->disabled()
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabel(): void
    {
        // Enclosed by label `false`.
        $expected = <<<HTML
        <div>
        <label for="typeform-bool">Bool</label>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool')
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabelWithLabelAttributes(): void
    {
        // Enclosed by label `false` with label attributes.
        $expected = <<<HTML
        <div>
        <label class="test-class" for="typeform-bool">Bool</label>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->labelClass('test-class')
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true` with label attributes.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label class="test-class"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['labelAttributes()' => [['class' => 'test-class']]])
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabelCustomText(): void
    {
        // Enclosed by label `false` with custom text.
        $expected = <<<HTML
        <div>
        <label for="typeform-bool">test-text-label</label>
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['enclosedByLabel()' => [false]])
                ->label('test-text-label')
                ->value(true)
                ->render(),
        );

        // Enclosed by label `true` with custom text.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> test-text-label</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['label()' => ['test-text-label']])
                ->value(true)
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
        <input type="hidden" name="ValidatorForm[required]" value="0"><label><input type="checkbox" id="validatorform-required" name="ValidatorForm[required]" required> Required</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new ValidatorForm(), 'required')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label class="test-class"><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Label:</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(
                    new TypeForm(),
                    'int',
                    ['label()' => ['Label:'], 'labelAttributes()' => [['class' => 'test-class']]]
                )
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelClass(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label class="test-class"><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int', ['labelAttributes()' => [['class' => 'test-class']]])
                ->value(1)
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
        <input type="hidden" name="name-test" value="0"><label><input type="checkbox" id="typeform-int" name="name-test" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int')
                ->name('name-test')
                ->value(1)
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
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" required> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int')
                ->required()
                ->value(1)
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
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool')
                ->value('1')
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
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" tabindex="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool')
                ->tabindex(1)
                ->value('1')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['uncheckValue()' => ['0']])
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value bool `false`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool')
                ->value(false)
                ->render(),
        );

        // Value bool `true`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'bool', ['checked()' => [true]])
                ->value('1')
                ->render(),
        );

        // Value int `0`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int')
                ->value(0)
                ->render(),
        );

        // Value int `1`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int', ['checked()' => [true]])
                ->value(1)
                ->render(),
        );

        // Value string `inactive`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'string')
                ->value('inactive')
                ->render(),
        );

        // Value string `active`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'string', ['checked()' => [true]])
                ->value('active')
                ->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox(new TypeForm(), 'int')
                ->value(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget value can not be an iterable or an object.');
        Field::widget()
            ->checkbox(new TypeForm(), 'array')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new typeForm();

        // Value bool `true`.
        $formModel->setAttribute('bool', true);

        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->checkbox($formModel, 'bool')
            ->value(false)
            ->render());
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->checkbox($formModel, 'bool')
            ->value('1')
            ->render());

        // Value int `1`.
        $formModel->setAttribute('int', 1);

        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->checkbox($formModel, 'int')
            ->value(0)
            ->render());
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->checkbox($formModel, 'int')
            ->value(1)
            ->render());

        // Value string `active`.
        $formModel->setAttribute('string', 'active');

        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="inactive"> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox($formModel, 'string')
                ->value('inactive')
                ->render(),
        );
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="active" checked> String</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->checkbox($formModel, 'string')
                ->value('active')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('int', 'null');

        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->checkbox($formModel, 'int')
            ->value(1)
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <div>
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" name="TypeForm[int]" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->id(null)
                ->checkbox(new TypeForm(), 'int')
                ->value(1)
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
        <label><input type="checkbox" id="typeform-int" value="1"> Int</label>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->name(null)
                ->checkbox(new TypeForm(), 'int')
                ->value(1)
                ->render(),
        );
    }
}
