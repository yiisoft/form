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
use Yiisoft\Form\Widget\DateTimeLocal;

final class DateTimeLocalTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" autofocus>',
            DateTimeLocal::widget()->autofocus()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" disabled>',
            DateTimeLocal::widget()->disabled()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testGetValidatorAttributeRequired(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="validatorform-required" name="ValidatorForm[required]" required>',
            DateTimeLocal::widget()->for(new ValidatorForm(), 'required')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="id-test" name="TypeForm[toDate]">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $dateTimeLocal = DateTimeLocal::widget();
        $this->assertNotSame($dateTimeLocal, $dateTimeLocal->max(''));
        $this->assertNotSame($dateTimeLocal, $dateTimeLocal->min(''));
        $this->assertNotSame($dateTimeLocal, $dateTimeLocal->readonly());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" max="1985-04-12T23:20:50.52">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->max('1985-04-12T23:20:50.52')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" min="1985-04-12T23:20:50.52">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->min('1985-04-12T23:20:50.52')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="name-test">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" readonly>',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" required>',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" tabindex="1">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->value('2021-09-18T23:59:00')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTimeLocal widget requires a string or null value.');
        DateTimeLocal::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `2021-09-18`.
        $formModel->setAttribute('toDate', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">',
            DateTimeLocal::widget()->for($formModel, 'toDate')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('toDate', null);
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate" name="TypeForm[toDate]">',
            DateTimeLocal::widget()->for($formModel, 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="datetime-local" name="TypeForm[toDate]">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="datetime-local" id="typeform-todate">',
            DateTimeLocal::widget()->for(new TypeForm(), 'toDate')->name(null)->render(),
        );
    }
}
