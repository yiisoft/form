<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Date;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DateTest extends TestCase
{
    use TestTrait;

    private TypeForm $formModel;

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]">',
            Date::widget()->config($this->formModel, 'toDate')->render(),
        );
    }

    public function testValue(): void
    {
        // string '2021-09-18'
        $this->formModel->setAttribute('toDate', '2021-09-18');
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]" value="2021-09-18">',
            Date::widget()->config($this->formModel, 'toDate')->render(),
        );

        // value null
        $this->formModel->setAttribute('toDate', null);
        $this->assertSame(
            '<input type="date" id="typeform-todate" name="TypeForm[toDate]">',
            Date::widget()->config($this->formModel, 'toDate')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->formModel->setAttribute('array', []);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Date widget requires a string or null value.');
        Date::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
