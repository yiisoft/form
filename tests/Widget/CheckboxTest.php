<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\Form\ValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Checkbox;

final class CheckboxTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" autofocus> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->autofocus()
                ->for(new TypeForm(), 'bool')
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testChecked(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->checked()
                ->for(new TypeForm(), 'bool')
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0" disabled><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" disabled> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->disabled()
                ->for(new TypeForm(), 'bool')
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testEnclosedByLabel(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1">
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->enclosedByLabel(false)
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
        <input type="hidden" name="ValidatorForm[required]" value="0"><label><input type="checkbox" id="validatorform-required" name="ValidatorForm[required]" required> Required</label>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Checkbox::widget()
                ->for(new ValidatorForm(), 'required')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="id-test" name="TypeForm[bool]" value="1"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->id('id-test')
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $checkbox = Checkbox::widget();
        $this->assertNotSame($checkbox, $checkbox->checked(false));
        $this->assertNotSame($checkbox, $checkbox->enclosedByLabel(false));
        $this->assertNotSame($checkbox, $checkbox->label(''));
        $this->assertNotSame($checkbox, $checkbox->labelAttributes([]));
        $this->assertNotSame($checkbox, $checkbox->uncheckValue('0'));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testLabelWithLabelAttributes(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label class="test-class"><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> test-text-label</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->label('test-text-label')
                ->labelAttributes(['class' => 'test-class'])
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="name-test" value="0"><label><input type="checkbox" id="typeform-bool" name="name-test" value="1"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->name('name-test')
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" required> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->required()
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for(new TypeForm(), 'bool')
            ->value(true)
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" tabindex="1"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->tabindex(1)
                ->value(true)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="1"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->uncheckValue('1')
                ->render(),
        );

        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->uncheckValue(0)
                ->render(),
        );

        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]"> Bool</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->uncheckValue(false)
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
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for(new TypeForm(), 'bool')
            ->value(false)
            ->render());

        // Value bool `true`.
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->checked()
            ->for(new TypeForm(), 'bool')
            ->value(true)
            ->render());

        // Value int `0`.
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for(new TypeForm(), 'int')
            ->value(0)
            ->render());

        // Value int `1`.
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->checked()
            ->for(new TypeForm(), 'int')
            ->value(1)
            ->render());

        // Value string '0'.
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="0"> String</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for(new TypeForm(), 'string')
            ->value('0')
            ->render());

        // Value string '1'.
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>
        HTML;
        $this->assertSame(
            $expected,
            Checkbox::widget()
                ->checked()
                ->for(new TypeForm(), 'string')
                ->value('1')
                ->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for(new TypeForm(), 'int')
            ->value(null)
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Checkbox widget value can not be an iterable or an object.');
        Checkbox::widget()
            ->for(new TypeForm(), 'array')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value bool `true`.
        $formModel->setAttribute('bool', true);

        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="0"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'bool')
            ->value(false)
            ->render());
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" id="typeform-bool" name="TypeForm[bool]" value="1" checked> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'bool')
            ->value(true)
            ->render());

        // Value int `1`.
        $formModel->setAttribute('int', 1);

        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="0"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'int')
            ->value(0)
            ->render());
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1" checked> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'int')
            ->value(1)
            ->render());

        // Value string '1'.
        $formModel->setAttribute('string', '1');

        $expected = <<<HTML
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="0"> String</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'string')
            ->value('0')
            ->render());
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[string]" value="0"><label><input type="checkbox" id="typeform-string" name="TypeForm[string]" value="1" checked> String</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'string')
            ->value('1')
            ->render());

        // Value `null`.
        $formModel->setAttribute('int', null);

        $expected = <<<HTML
        <input type="hidden" name="TypeForm[int]" value="0"><label><input type="checkbox" id="typeform-int" name="TypeForm[int]" value="1"> Int</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for($formModel, 'int')
            ->value('1')
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<HTML
        <input type="hidden" name="TypeForm[bool]" value="0"><label><input type="checkbox" name="TypeForm[bool]" value="1"> Bool</label>
        HTML;
        $this->assertSame($expected, Checkbox::widget()
            ->for(new TypeForm(), 'bool')
            ->id(null)
            ->value(true)
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<label><input type="checkbox" id="typeform-bool" value="1"> Bool</label>',
            Checkbox::widget()
                ->for(new TypeForm(), 'bool')
                ->name(null)
                ->value(true)
                ->render(),
        );
    }
}
