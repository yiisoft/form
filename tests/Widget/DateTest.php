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
use Yiisoft\Form\Widget\Date;

final class DateTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testAutofocus(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" autofocus>',
            Date::widget()->autofocus()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testDisabled(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" disabled>',
            Date::widget()->disabled()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testId(): void
    {
        $this->assertSame(
            '<input type="date" id="id-test" name="TypeForm[toDate]">',
            Date::widget()->for(new TypeForm(), 'toDate')->id('id-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $date = Date::widget();
        $this->assertNotSame($date, $date->max(''));
        $this->assertNotSame($date, $date->min(''));
        $this->assertNotSame($date, $date->readonly());
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" max="1996-12-19">',
            Date::widget()->for(new TypeForm(), 'toDate')->max('1996-12-19')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" min="1996-12-19">',
            Date::widget()->for(new TypeForm(), 'toDate')->min('1996-12-19')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testName(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="name-test">',
            Date::widget()->for(new TypeForm(), 'toDate')->name('name-test')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" readonly>',
            Date::widget()->for(new TypeForm(), 'toDate')->readonly()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRequired(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" required>',
            Date::widget()->for(new TypeForm(), 'toDate')->required()->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]">',
            Date::widget()->for(new TypeForm(), 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testTabIndex(): void
    {
        $this->assertEqualsWithoutLE(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" tabindex="1">',
            Date::widget()->for(new TypeForm(), 'toDate')->tabIndex(1)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValue(): void
    {
        // Value string `2021-09-18`.
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18">',
            Date::widget()->for(new TypeForm(), 'toDate')->value('2021-09-18')->render(),
        );

        // Value `null`.
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]">',
            Date::widget()->for(new TypeForm(), 'toDate')->value(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Date widget requires a string or null value.');
        Date::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value string `2021-09-18`.
        $formModel->setAttribute('toDate', '2021-09-18');
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18">',
            Date::widget()->for($formModel, 'toDate')->render(),
        );

        // Value `null`.
        $formModel->setAttribute('toDate', null);
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]">',
            Date::widget()->for($formModel, 'toDate')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutId(): void
    {
        $this->assertSame(
            '<input type="date" name="TypeForm[toDate]">',
            Date::widget()->for(new TypeForm(), 'toDate')->id(null)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testWithoutName(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate">',
            Date::widget()->for(new TypeForm(), 'toDate')->name(null)->render(),
        );
    }
}
