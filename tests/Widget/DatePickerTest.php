<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\DatePicker;

final class DatePickerTest extends TestCase
{
    public function testDatePicker(): void
    {
        $form = new StubForm();
        $form->fieldString('2020-20-04');

        $expected = '<input type="date" id="stubform-fieldstring" name="StubForm[fieldString]" value="2020-20-04">';
        $created = (new DatePicker())
            ->form($form)
            ->attribute('fieldString')
            ->options([])
            ->run();
        $this->assertEquals($expected, $created);
    }
}
