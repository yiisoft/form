<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\DateTime;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DateTimeTest extends TestCase
{
    use TestTrait;

    public function testImmutability(): void
    {
        $dateTime = DateTime::widget();
        $this->assertNotSame($dateTime, $dateTime->max(''));
        $this->assertNotSame($dateTime, $dateTime->min(''));
        $this->assertNotSame($dateTime, $dateTime->readonly());
    }

    public function testMax(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" max="1990-12-31T23:59:60Z">',
            DateTime::widget()->for($this->formModel, 'toDate')->max('1990-12-31T23:59:60Z')->render(),
        );
    }

    public function testMin(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" min="1990-12-31T23:59:60Z">',
            DateTime::widget()->for($this->formModel, 'toDate')->min('1990-12-31T23:59:60Z')->render(),
        );
    }

    public function testReadonly(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" readonly>',
            DateTime::widget()->for($this->formModel, 'toDate')->readonly()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]">',
            DateTime::widget()->for($this->formModel, 'toDate')->render(),
        );
    }

    public function testValue(): void
    {
        // string '2021-09-18'
        $this->formModel->setAttribute('toDate', '2021-09-18T23:59:00');
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18T23:59:00">',
            DateTime::widget()->for($this->formModel, 'toDate')->render(),
        );

        // value null
        $this->formModel->setAttribute('toDate', null);
        $this->assertSame(
            '<input type="datetime" id="typeform-todate" name="TypeForm[toDate]">',
            DateTime::widget()->for($this->formModel, 'toDate')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('DateTime widget requires a string or null value.');
        DateTime::widget()->for($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
