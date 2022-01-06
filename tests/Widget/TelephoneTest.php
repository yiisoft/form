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
use Yiisoft\Form\Widget\Telephone;

final class TelephoneTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" autofocus>',
            Telephone::widget()->autofocus()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" disabled>',
            Telephone::widget()->disabled()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorMatchRegularExpression(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">',
            Telephone::widget()->for(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Telephone::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Telephone::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="tel" id="validatorform-required" name="ValidatorForm[required]" required>',
            Telephone::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="tel" id="id-test" name="TypeForm[string]">',
            Telephone::widget()->for(new TypeForm(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $telephone = Telephone::widget();
        $this->assertNotSame($telephone, $telephone->maxlength(0));
        $this->assertNotSame($telephone, $telephone->minlength(0));
        $this->assertNotSame($telephone, $telephone->pattern(''));
        $this->assertNotSame($telephone, $telephone->placeholder(''));
        $this->assertNotSame($telephone, $telephone->readonly());
        $this->assertNotSame($telephone, $telephone->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Telephone::widget()->for(new TypeForm(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Telephone::widget()->for(new TypeForm(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="name-test">',
            Telephone::widget()->for(new TypeForm(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" pattern="[789][0-9]{9}">',
            Telephone::widget()->for(new TypeForm(), 'string')->pattern('[789][0-9]{9}')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Telephone::widget()->for(new TypeForm(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" readonly>',
            Telephone::widget()->for(new TypeForm(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" required>',
            Telephone::widget()->for(new TypeForm(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]">',
            Telephone::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" size="20">',
            Telephone::widget()->for(new TypeForm(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `+71234567890`.
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" value="+71234567890">',
            Telephone::widget()->for(new TypeForm(), 'string')->value('+71234567890')->render(),
        );

        // Value numeric string `71234567890`.
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" value="71234567890">',
            Telephone::widget()->for(new TypeForm(), 'string')->value('71234567890')->render(),
        );

        // Value integer `71234567890`.
        $this->assertSame(
            '<input type="tel" id="typeform-int" name="TypeForm[int]" value="71234567890">',
            Telephone::widget()->for(new TypeForm(), 'int')->value(71234567890)->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]">',
            Telephone::widget()->for(new TypeForm(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone widget must be a string, numeric or null.');
        Telephone::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `+71234567890`.
        $formModel->setAttribute('string', '+71234567890');
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" value="+71234567890">',
            Telephone::widget()->for($formModel, 'string')->render(),
        );

        // Value numeric string `71234567890`.
        $formModel->setAttribute('string', '71234567890');
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" value="71234567890">',
            Telephone::widget()->for($formModel, 'string')->render(),
        );

        // Value integer `71234567890`.
        $formModel->setAttribute('int', 71234567890);
        $this->assertSame(
            '<input type="tel" id="typeform-int" name="TypeForm[int]" value="71234567890">',
            Telephone::widget()->for($formModel, 'int')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]">',
            Telephone::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="tel" name="TypeForm[string]">',
            Telephone::widget()->for(new TypeForm(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string">',
            Telephone::widget()->for(new TypeForm(), 'string')->name(null)->render(),
        );
    }
}
