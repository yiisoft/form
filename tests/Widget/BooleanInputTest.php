<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;
use Yiisoft\Form\Widget\BooleanInput;

final class BooleanInputTest extends TestCase
{
    public function testCheckbox(): void
    {
        $form = new StubForm();

        $form->fieldBool(false);
        $expected = '<input type="checkbox" id="stubform-fieldbool" name="StubForm[fieldBool]" value="1">';
        $created = BooleanInput::widget()
            ->type('checkbox')
            ->config($form, 'fieldBool')
            ->addLabel(false)
            ->uncheck(false)
            ->run();
        $this->assertEquals($expected, $created);

        $form->fieldBool(true);
        $expected = '<input type="hidden" name="StubForm[fieldBool]" value="0">' .
            '<label><input type="checkbox" id="stubform-fieldbool" name="StubForm[fieldBool]" value="1" checked> Field Bool</label>';
        $created = BooleanInput::widget()
            ->type('checkbox')
            ->config($form, 'fieldBool')
            ->addLabel(true)
            ->uncheck(true)
            ->run();
        $this->assertEquals($expected, $created);

        $form->fieldBool(false);
        $expected = '<input type="radio" id="stubform-fieldbool" name="StubForm[fieldBool]" value="1">';
        $created = BooleanInput::widget()
            ->type('radio')
            ->config($form, 'fieldBool')
            ->addLabel(false)
            ->uncheck(false)
            ->run();
        $this->assertEquals($expected, $created);

        $form->fieldBool(true);
        $expected = '<input type="hidden" name="StubForm[fieldBool]" value="0">' .
            '<label><input type="radio" id="id-testme" name="StubForm[fieldBool]" value="1" checked> Field Bool</label>';
        $created = BooleanInput::widget()
            ->id('id-testme')
            ->type('radio')
            ->config($form, 'fieldBool')
            ->addLabel(true)
            ->uncheck(true)
            ->run();
        $this->assertEquals($expected, $created);
    }
}
