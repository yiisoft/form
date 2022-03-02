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
use Yiisoft\Form\Widget\Email;

final class EmailTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" autofocus>',
            Email::widget()->autofocus()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" disabled>',
            Email::widget()->disabled()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorform-regex" name="ValidatorForm[regex]" pattern="\w+">',
            Email::widget()->for(new ValidatorForm(), 'regex')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Email::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Email::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="email" id="validatorform-required" name="ValidatorForm[required]" required>',
            Email::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="email" id="id-test" name="TypeForm[string]">',
            Email::widget()->for(new TypeForm(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $email = Email::widget();
        $this->assertNotSame($email, $email->maxlength(0));
        $this->assertNotSame($email, $email->minlength(0));
        $this->assertNotSame($email, $email->multiple());
        $this->assertNotSame($email, $email->pattern(''));
        $this->assertNotSame($email, $email->placeholder(''));
        $this->assertNotSame($email, $email->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Email::widget()->for(new TypeForm(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Email::widget()->for(new TypeForm(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" value="email1@example.com;email2@example.com;" multiple>',
            Email::widget()
                ->for(new TypeForm(), 'string')
                ->multiple(true)
                ->value('email1@example.com;email2@example.com;')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="name-test">',
            Email::widget()->for(new TypeForm(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="email" id="typeform-string" name="TypeForm[string]" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}">
        HTML;
        $html = Email::widget()
            ->for(new TypeForm(), 'string')
            ->pattern('[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Email::widget()->for(new TypeForm(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" readonly>',
            Email::widget()->for(new TypeForm(), 'string')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" required>',
            Email::widget()->for(new TypeForm(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]">',
            Email::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" size="20">',
            Email::widget()->for(new TypeForm(), 'string')->size(20)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" tabindex="1">',
            Email::widget()->for(new TypeForm(), 'string')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `email1@example.com;`.
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" value="email1@example.com;">',
            Email::widget()->for(new TypeForm(), 'string')->value('email1@example.com;')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]">',
            Email::widget()->for(new TypeForm(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email widget must be a string or null value.');
        Email::widget()->for(new TypeForm(), 'int')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `email1@example.com;`.
        $formModel->setAttribute('string', 'email1@example.com;');
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]" value="email1@example.com;">',
            Email::widget()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="email" id="typeform-string" name="TypeForm[string]">',
            Email::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="email" name="TypeForm[string]">',
            Email::widget()->for(new TypeForm(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="email" id="typeform-string">',
            Email::widget()->for(new TypeForm(), 'string')->name(null)->render(),
        );
    }
}
