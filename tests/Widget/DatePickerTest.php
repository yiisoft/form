<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Widget\DatePicker;

final class DatePickerTest extends TestCase
{
    public function testDatePicker(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20">
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerOptions(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" class="customClass" name="PersonalForm[entryDate]" value="2019-04-20">
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerAutofocus(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20" autofocus>
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerDisabled(): void
    {
        $data = new PersonalForm();
        $data->entryDate('2019-04-20');

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20" disabled>
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerMin(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" min="2020-05-01">
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->min('2020-05-01')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerMax(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" max="2020-12-31">
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->max('2020-12-31')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" required>
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->required()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testDatePickerTabIndex(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" tabindex="5">
HTML;
        $html = DatePicker::widget()
            ->config($data, 'entryDate')
            ->tabIndex(5)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
