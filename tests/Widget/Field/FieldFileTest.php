<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\Form\ValidatorForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;

final class FieldFileTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAccept(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" accept="image/*">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array', ['accept()' => ['image/*']])
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->autofocus()
                ->file(new TypeForm(), 'array')
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->disabled()
                ->file(new TypeForm(), 'array')
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
        <input type="file" id="validatorform-required" name="ValidatorForm[required][]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new ValidatorForm(), 'required')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <input type="hidden" id="test-id" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(
                    new TypeForm(),
                    'array',
                    ['uncheckValue()' => ['0'], 'hiddenAttributes()' => [['id' => 'test-id']]]
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
        <label for="id-test">Array</label>
        <input type="file" id="id-test" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
                ->id('id-test')
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
        <input type="file" id="typeform-array" name="TypeForm[array][]" multiple>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array', ['multiple()' => [true]])
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="name-test[]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
                ->name('name-test')
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
                ->tabindex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-array">Array</label>
        <input type="hidden" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array', ['uncheckValue()' => ['0']])
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
        <label>Array</label>
        <input type="file" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
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
        <label for="typeform-array">Array</label>
        <input type="file" id="typeform-array" name="TypeForm[array][]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->file(new TypeForm(), 'array')
                ->name(null)
                ->render(),
        );
    }
}
