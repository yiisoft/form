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
use Yiisoft\Form\Widget\Text;

final class TextTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" autofocus>',
            Text::widget()->autofocus()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirname(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" dirname="test.dir">',
            Text::widget()->for(new TypeForm(), 'string')->dirname('test.dir')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        Text::widget()->for(new TypeForm(), 'login')->dirname('')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" disabled>',
            Text::widget()->disabled()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorMatchRegularExpression(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-matchregular" name="ValidatorForm[matchregular]" pattern="\w+">',
            Text::widget()->for(new ValidatorForm(), 'matchregular')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50">',
            Text::widget()->for(new ValidatorForm(), 'maxlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15">',
            Text::widget()->for(new ValidatorForm(), 'minlength')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="text" id="validatorform-required" name="ValidatorForm[required]" required>',
            Text::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="text" id="id-test" name="TypeForm[string]">',
            Text::widget()->for(new TypeForm(), 'string')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $text = Text::widget();
        $this->assertNotSame($text, $text->dirname('test.dir'));
        $this->assertNotSame($text, $text->maxlength(0));
        $this->assertNotSame($text, $text->placeholder(''));
        $this->assertNotSame($text, $text->pattern(''));
        $this->assertNotSame($text, $text->readOnly());
        $this->assertNotSame($text, $text->size(0));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Text::widget()->for(new TypeForm(), 'string')->maxlength(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Text::widget()->for(new TypeForm(), 'string')->minlength(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="name-test">',
            Text::widget()->for(new TypeForm(), 'string')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPattern(): void
    {
        $expected = <<<'HTML'
        <input type="text" id="typeform-string" name="TypeForm[string]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]">
        HTML;
        $html = Text::widget()
            ->for(new TypeForm(), 'string')
            ->pattern('[A-Za-z]')
            ->title('Only accepts uppercase and lowercase letters.')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Text::widget()->for(new TypeForm(), 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadOnly(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" readonly>',
            Text::widget()->for(new TypeForm(), 'string')->readOnly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" required>',
            Text::widget()->for(new TypeForm(), 'string')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]">',
            Text::widget()->for(new TypeForm(), 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testSize(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" size="10">',
            Text::widget()->for(new TypeForm(), 'string')->size(10)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" tabindex="1">',
            Text::widget()->for(new TypeForm(), 'string')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `hello`.
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" value="hello">',
            Text::widget()->for(new TypeForm(), 'string')->value('hello')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]">',
            Text::widget()->for(new TypeForm(), 'string')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Text widget must be a string or null value.');
        Text::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `hello`.
        $formModel->setAttribute('string', 'hello');
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]" value="hello">',
            Text::widget()->for($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<input type="text" id="typeform-string" name="TypeForm[string]">',
            Text::widget()->for($formModel, 'string')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="text" name="TypeForm[string]">',
            Text::widget()->for(new TypeForm(), 'string')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="text" id="typeform-string">',
            Text::widget()->for(new TypeForm(), 'string')->name(null)->render(),
        );
    }
}
