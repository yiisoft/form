<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\Form\ValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\File;

final class FileTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAccept(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" accept="image/*">',
            File::widget()->for(new TypeForm(), 'array')->accept('image/*')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" autofocus>',
            File::widget()->for(new TypeForm(), 'array')->autofocus()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" disabled>',
            File::widget()->for(new TypeForm(), 'array')->disabled()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="file" id="validatorform-required" name="ValidatorForm[required][]" required>',
            File::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" id="test-id" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $html = File::widget()
            ->for(new TypeForm(), 'array')
            ->hiddenAttributes(['id' => 'test-id'])
            ->uncheckValue('0')
            ->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="file" id="id-test" name="TypeForm[array][]">',
            File::widget()->for(new TypeForm(), 'array')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $fileInput = File::widget();
        $this->assertNotSame($fileInput, $fileInput->accept(''));
        $this->assertNotSame($fileInput, $fileInput->hiddenAttributes([]));
        $this->assertNotSame($fileInput, $fileInput->multiple());
        $this->assertNotSame($fileInput, $fileInput->uncheckValue(true));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" multiple>',
            File::widget()->for(new TypeForm(), 'array')->multiple()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="name-test[]">',
            File::widget()->for(new TypeForm(), 'array')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" required>',
            File::widget()->for(new TypeForm(), 'array')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]">',
            File::widget()->for(new TypeForm(), 'array')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" tabindex="1">',
            File::widget()->for(new TypeForm(), 'array')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $html = File::widget()->for(new TypeForm(), 'array')->uncheckValue('0')->render();
        $this->assertSame($expected, $html);

        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[array]" value="1"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $html = File::widget()->for(new TypeForm(), 'array')->uncheckValue(true)->render();
        $this->assertSame($expected, $html);
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="file" name="TypeForm[array][]">',
            File::widget()->for(new TypeForm(), 'array')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]">',
            File::widget()->for(new TypeForm(), 'array')->name(null)->render(),
        );
    }
}
