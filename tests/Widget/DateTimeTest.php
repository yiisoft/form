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
use Yiisoft\Form\Widget\DateTime;

final class DateTimeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" autofocus>',
            DateTime::widget()->autofocus()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" disabled>',
            DateTime::widget()->disabled()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="datetime" id="id-test" name="TypeForm[toDate]">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $dateTime = DateTime::widget();
        $this->assertNotSame($dateTime, $dateTime->max(''));
        $this->assertNotSame($dateTime, $dateTime->min(''));
        $this->assertNotSame($dateTime, $dateTime->readonly());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" max="1990-12-31T23:59:60Z">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->max('1990-12-31T23:59:60Z')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" min="1990-12-31T23:59:60Z">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->min('1990-12-31T23:59:60Z')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="name-test">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" readonly>',
            DateTime::widget()->for(new TypeForm(), 'toDate')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" required>',
            DateTime::widget()->for(new TypeForm(), 'toDate')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabindex(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" tabindex="1">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->tabindex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->value('2021-09-18T23:59:00')->render(),
        );

        // Value `null`
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTime widget requires a string or null value.');
        DateTime::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValuWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `2021-09-18`.
        $formModel->setAttribute('toDate', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">',
            DateTime::widget()->for($formModel, 'toDate')->render(),
        );

        // Value `null`
        $formModel->setAttribute('toDate', null);
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]">',
            DateTime::widget()->for($formModel, 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="datetime" name="TypeForm[toDate]">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate">',
            DateTime::widget()->for(new TypeForm(), 'toDate')->name(null)->render(),
        );
    }
}
