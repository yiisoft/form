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
use Yiisoft\Form\Widget\TextArea;

final class TextAreaTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" autofocus></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->autofocus()
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testCols(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" cols="50"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->cols(50)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirname(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" dirname="test.dir"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->dirname('test.dir')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDirnameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value cannot be empty.');
        TextArea::widget()
            ->for(new TypeForm(), 'string')
            ->dirname('')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" disabled></textarea>',
            TextArea::widget()
                ->disabled()
                ->for(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="validatorform-maxlength" name="ValidatorForm[maxlength]" maxlength="50"></textarea>',
            TextArea::widget()
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
            '<textarea id="validatorform-minlength" name="ValidatorForm[minlength]" minlength="15"></textarea>',
            TextArea::widget()
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
            '<textarea id="validatorform-required" name="ValidatorForm[required]" required></textarea>',
            TextArea::widget()
                ->for(new ValidatorForm(), 'required')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $textArea = TextArea::widget();
        $this->assertNotSame($textArea, $textArea->cols(0));
        $this->assertNotSame($textArea, $textArea->dirname('test.dir'));
        $this->assertNotSame($textArea, $textArea->maxlength(0));
        $this->assertNotSame($textArea, $textArea->minlength(0));
        $this->assertNotSame($textArea, $textArea->placeholder(''));
        $this->assertNotSame($textArea, $textArea->readOnly());
        $this->assertNotSame($textArea, $textArea->rows(0));
        $this->assertNotSame($textArea, $textArea->wrap('hard'));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMaxLength(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" maxlength="100"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->maxLength(100)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMinLength(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" minlength="20"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->minLength(20)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="name-test"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
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
            '<textarea id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text"></textarea>',
            TextArea::widget()
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
            '<textarea id="typeform-string" name="TypeForm[string]" readonly></textarea>',
            TextArea::widget()
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
            '<textarea id="typeform-string" name="TypeForm[string]" required></textarea>',
            TextArea::widget()
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
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRows(): void
    {
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" rows="4"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->rows(4)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `hello`.
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]">hello</textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->value('hello')
                ->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()
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
        $this->expectExceptionMessage('TextArea widget must be a string or null value.');
        TextArea::widget()
            ->for(new TypeForm(), 'array')
            ->render();
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
            '<textarea id="typeform-string" name="TypeForm[string]">hello</textarea>',
            TextArea::widget()
                ->for($formModel, 'string')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('string', null);
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]"></textarea>',
            TextArea::widget()
                ->for($formModel, 'string')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWrap(): void
    {
        /** hard value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="hard"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->wrap()
                ->render(),
        );

        /** soft value */
        $this->assertSame(
            '<textarea id="typeform-string" name="TypeForm[string]" wrap="soft"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->wrap('soft')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWrapException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid wrap value. Valid values are: hard, soft.');
        TextArea::widget()
            ->for(new TypeForm(), 'string')
            ->wrap('exception');
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<textarea name="TypeForm[string]"></textarea>',
            TextArea::widget()
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
            '<textarea id="typeform-string"></textarea>',
            TextArea::widget()
                ->for(new TypeForm(), 'string')
                ->name(null)
                ->render(),
        );
    }
}
