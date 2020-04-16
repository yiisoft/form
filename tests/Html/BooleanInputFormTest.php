<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\BooleanInputForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class BooleanInputFormTest extends TestCase
{
    public function testCheckboxForm()
    {
        $form = new StubForm();

        $expected = '<input type="hidden" name="StubForm[fieldBool]" value="0"><label><input type="checkbox" id="stubform-fieldbool" name="StubForm[fieldBool]" value="1" checked> Field Bool</label>';
        $this->assertEquals($expected, BooleanInputForm::create('checkbox', $form, 'fieldBool'));

        $expected = '<input type="hidden" name="StubForm[fieldBool]" value="0"><label><input type="radio" id="stubform-fieldbool" name="StubForm[fieldBool]" value="1" checked> Field Bool</label>';
        $this->assertEquals($expected, BooleanInputForm::create('radio', $form, 'fieldBool'));

    }
}
