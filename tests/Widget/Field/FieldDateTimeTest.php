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

final class FieldDateTimeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" autofocus>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->autofocus()
                ->dateTime(new TypeForm(), 'toDate')
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
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" disabled>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->disabled()
                ->dateTime(new TypeForm(), 'toDate')
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
        <input type="datetime" id="validatorform-required" name="ValidatorForm[required]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new ValidatorForm(), 'required')
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
        <label for="id-test">To Date</label>
        <input type="datetime" id="id-test" name="TypeForm[toDate]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
                ->id('id-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" max="1990-12-31T23:59:60Z">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate', ['max()' => ['1990-12-31T23:59:60Z']])
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" min="1990-12-31T23:59:60Z">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate', ['min()' => ['1990-12-31T23:59:60Z']])
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
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="name-test">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
                ->name('name-test')
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" readonly>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
                ->readonly()
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
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" required>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
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
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Field::widget()
            ->dateTime(new TypeForm(), 'toDate')
            ->render());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" tabindex="1">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
                ->tabindex(1)
                ->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
                ->value('2021-09-18T23:59:00')
                ->render(),
        );

        // Value `null`.
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
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
        $this->expectExceptionMessage('DateTime widget requires a string or null value.');
        Field::widget()
            ->dateTime(new TypeForm(), 'array')
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `2021-09-18`.
        $formModel->setAttribute('toDate', '2021-09-18T23:59:00');
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime($formModel, 'toDate')
                ->render(),
        );

        // Value `null`.
        $formModel->setAttribute('toDate', null);
        $expected = <<<HTML
        <div>
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate" name="TypeForm[toDate]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime($formModel, 'toDate')
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
        <label>To Date</label>
        <input type="datetime" name="TypeForm[toDate]">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
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
        <label for="typeform-todate">To Date</label>
        <input type="datetime" id="typeform-todate">
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Field::widget()
                ->dateTime(new TypeForm(), 'toDate')
                ->name(null)
                ->render(),
        );
    }
}
