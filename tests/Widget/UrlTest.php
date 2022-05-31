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
use Yiisoft\Form\Widget\Url;

final class UrlTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" autofocus>',
            Url::widget()
                ->autofocus()
                ->for(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="url" id="typeform-string" name="TypeForm[string]" disabled>',
            Url::widget()
                ->disabled()
                ->for(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRegex(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-regex" name="ValidatorForm[regex]" pattern="\w+">',
            Url::widget()
                ->for(new ValidatorForm(), 'regex')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Url::widget()
                ->for(new ValidatorForm(), 'maxlength')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Url::widget()
                ->for(new ValidatorForm(), 'minlength')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="validatorform-required" name="ValidatorForm[required]" required>',
            Url::widget()
                ->for(new ValidatorForm(), 'required')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeUrlValidator(): void
    {
        $expected = <<<HTML
        <input type="url" id="validatorform-url" name="ValidatorForm[url]" pattern="^([hH][tT][tT][pP]|[hH][tT][tT][pP][sS]):\/\/(([a-zA-Z0-9][a-zA-Z0-9_-]*)(\.[a-zA-Z0-9][a-zA-Z0-9_-]*)+)(?::\d{1,5})?([?\/#].*$|$)">
        HTML;
        $this->assertSame($expected, Url::widget()
            ->for(new ValidatorForm(), 'url')
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="url" id="id-test" name="TypeForm[string]">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $url = Url::widget();
        $this->assertNotSame($url, $url->maxlength(0));
        $this->assertNotSame($url, $url->minlength(0));
        $this->assertNotSame($url, $url->pattern(''));
        $this->assertNotSame($url, $url->placeholder(''));
        $this->assertNotSame($url, $url->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->maxlength(10)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->minlength(4)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="name-test">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="url" id="typeform-string" name="TypeForm[string]" pattern="^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!$&amp;&apos;\(\)\*\+,;=.]+$">
        HTML;
        $html = Url::widget()
            ->for(new TypeForm(), 'string')
            ->pattern("^(http(s)?:\/\/)+[\w\-\._~:\/?#[\]@!\$&'\(\)\*\+,;=.]+$")
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Url::widget()
                ->for(new TypeForm(), 'string')
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
            '<input type="url" id="typeform-string" name="TypeForm[string]" readonly>',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->readOnly()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" required>',
            Url::widget()
                ->for(new TypeForm(), 'string')
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
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" size="20">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->size(20)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="url" id="typeform-string" name="TypeForm[string]" tabindex="1">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->tabIndex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `https://yiiframework.com`.
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->value('https://yiiframework.com')
                ->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()
                ->for(new TypeForm(), 'string')
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
        $this->expectExceptionMessage('Url widget must be a string or null value.');
        Url::widget()
            ->for(new TypeForm(), 'int')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `https://yiiframework.com`.
        $formModel->setAttribute('string', 'https://yiiframework.com');
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]" value="https://yiiframework.com">',
            Url::widget()
                ->for($formModel, 'string')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="url" id="typeform-string" name="TypeForm[string]">',
            Url::widget()
                ->for($formModel, 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="url" name="TypeForm[string]">',
            Url::widget()
                ->for(new TypeForm(), 'string')
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
            '<input type="url" id="typeform-string">',
            Url::widget()
                ->for(new TypeForm(), 'string')
                ->name(null)
                ->render(),
        );
    }
}
