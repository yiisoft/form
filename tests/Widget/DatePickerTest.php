<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\DatePicker;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DatePickerTest extends TestCase
{
    public function testAutofocus(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20" autofocus>',
            DatePicker::widget()->config($data, 'entryDate')->autofocus()->render(),
        );
    }

    public function testDisabled(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20" disabled>',
            DatePicker::widget()->config($data, 'entryDate')->disabled()->render()
        );
    }

    public function testMin(): void
    {
        $data = new PersonalForm();

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" min="2020-05-01">',
            DatePicker::widget()->config($data, 'entryDate')->min('2020-05-01')->render(),
        );
    }

    public function testMax(): void
    {
        $data = new PersonalForm();

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" max="2020-12-31">',
            DatePicker::widget()->config($data, 'entryDate')->max('2020-12-31')->render(),
        );
    }

    public function testRender(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20">',
            DatePicker::widget()->config($data, 'entryDate')->render(),
        );
    }

    public function testRequired(): void
    {
        $data = new PersonalForm();

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" required>',
            DatePicker::widget()->config($data, 'entryDate')->required()->render(),
        );
    }

    public function testTabIndex(): void
    {
        $data = new PersonalForm();

        $this->assertSame(
            '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" tabindex="5">',
            DatePicker::widget()->config($data, 'entryDate')->tabIndex(5)->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
