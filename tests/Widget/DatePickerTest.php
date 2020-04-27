<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\DatePicker;

final class DatePickerTest extends TestCase
{
    public function testDatePicker(): void
    {
        $form = new PersonalForm();
        $form->entryDate('2019-04-20');

        $expected = '<input type="date" id="personalform-entrydate" name="PersonalForm[entryDate]" value="2019-04-20">';
        $created = DatePicker::widget()
            ->config($form, 'entryDate')
            ->run();
        $this->assertEquals($expected, $created);
    }
}
