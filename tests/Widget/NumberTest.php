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
use Yiisoft\Form\Widget\Number;

final class NumberTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]" autofocus>',
            Number::widget()
                ->autofocus()
                ->for(new TypeForm(), 'number')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="number" id="typeform-number" name="TypeForm[number]" disabled>',
            Number::widget()
                ->disabled()
                ->for(new TypeForm(), 'number')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="number" id="validatorform-number" name="ValidatorForm[number]" value="0" max="5" min="3">',
            Number::widget()
                ->for(new ValidatorForm(), 'number')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<HTML
        <input type="number" id="validatorform-numberrequired" name="ValidatorForm[numberRequired]" value="0" required>
        HTML;
        $this->assertSame(
            $expected,
            Number::widget()
                ->for(new ValidatorForm(), 'numberRequired')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="number" id="id-test" name="TypeForm[number]">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $number = Number::widget();
        $this->assertNotSame($number, $number->max(0));
        $this->assertNotSame($number, $number->min(0));
        $this->assertNotSame($number, $number->placeholder(''));
        $this->assertNotSame($number, $number->readonly());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]" max="8">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->max(8)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]" min="4">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->min(4)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="name-test">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]" placeholder="PlaceHolder Text">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->placeholder('PlaceHolder Text')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]" readonly>',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->readonly()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]" required>',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->required()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number" name="TypeForm[number]">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="number" id="typeform-number" name="TypeForm[number]" tabindex="1">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->tabIndex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // value int `1`.
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="1">',
            Number::widget()
                ->for(new TypeForm(), 'int')
                ->value(1)
                ->render(),
        );

        // Value string numeric `1`.
        $this->assertSame(
            '<input type="number" id="typeform-string" name="TypeForm[string]" value="1">',
            Number::widget()
                ->for(new TypeForm(), 'string')
                ->value('1')
                ->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]">',
            Number::widget()
                ->for(new TypeForm(), 'int')
                ->value(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number widget must be a numeric or null value.');
        Number::widget()
            ->for(new TypeForm(), 'array')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // value int `1`.
        $formModel->setAttribute('int', 1);
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="1">',
            Number::widget()
                ->for($formModel, 'int')
                ->render(),
        );

        // Value string numeric `1`.
        $formModel->setAttribute('string', '1');
        $this->assertSame(
            '<input type="number" id="typeform-string" name="TypeForm[string]" value="1">',
            Number::widget()
                ->for($formModel, 'string')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('int', null);
        $this->assertSame(
            '<input type="number" id="typeform-int" name="TypeForm[int]" value="0">',
            Number::widget()
                ->for($formModel, 'int')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="number" name="TypeForm[number]">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->id(null)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="number" id="typeform-number">',
            Number::widget()
                ->for(new TypeForm(), 'number')
                ->name(null)
                ->render(),
        );
    }
}
