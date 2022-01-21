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

final class FieldNumberTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->autofocus()->number(new TypeForm(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->disabled()->number(new TypeForm(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeNumber(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorform-number">Number</label>
        <input type="number" id="validatorform-number" name="ValidatorForm[number]" value="0" max="5" min="3">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->number(new ValidatorForm(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="validatorform-numberrequired">Number Required</label>
        <input type="number" id="validatorform-numberrequired" name="ValidatorForm[numberRequired]" value="0" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new ValidatorForm(), 'numberRequired')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="id-test">Number</label>
        <input type="number" id="id-test" name="TypeForm[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->id('id-test')->number(new TypeForm(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" max="8">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number', ['max()' => [8]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" min="4">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number', ['min()' => [4]])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name('name-test')->number(new TypeForm(), 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testPlaceholder(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" placeholder="PlaceHolder Text">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number')->placeholder('PlaceHolder Text')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->number(new TypeForm(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value int `1`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number')->value(1)->render(),
        );

        // Value numeric string `1`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="number" id="typeform-string" name="TypeForm[string]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'string')->value('1')->render(),
        );

        // Value `null`.
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number(new TypeForm(), 'number')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Number widget must be a numeric or null value.');
        Field::widget()->number(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value int `1`.
        $formModel->setAttribute('number', 1);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number($formModel, 'number')->render(),
        );

        // Value numeric string `1`.
        $formModel->setAttribute('string', '1');
        $expected = <<<'HTML'
        <div>
        <label for="typeform-string">String</label>
        <input type="number" id="typeform-string" name="TypeForm[string]" value="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number($formModel, 'string')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('number', null);
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number" name="TypeForm[number]" value="0">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->number($formModel, 'number')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $expected = <<<'HTML'
        <div>
        <label>Number</label>
        <input type="number" name="TypeForm[number]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()->id(null)->number(new TypeForm(), 'number')->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="typeform-number">Number</label>
        <input type="number" id="typeform-number">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()->name(null)->number(new TypeForm(), 'number')->render(),
        );
    }
}
